<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

if (!function_exists('safeCache')) {
    /**
     * Safely retrieve an item from cache, auto-purging corrupt or incomplete objects.
     *
     * @param string $key
     * @param int $ttl
     * @param \Closure $callback
     * @return mixed
     */
    function safeCache(string $key, int $ttl, \Closure $callback)
    {
        try {
            $value = Cache::get($key);
            if ($value !== null) {
                $isCorrupt = false;
                if (is_object($value)) {
                    if (is_a($value, '__PHP_Incomplete_Class') || get_class($value) === '__PHP_Incomplete_Class') {
                        $isCorrupt = true;
                    }
                } elseif (is_iterable($value)) {
                    foreach ($value as $item) {
                        if (is_object($item) && (is_a($item, '__PHP_Incomplete_Class') || get_class($item) === '__PHP_Incomplete_Class')) {
                            $isCorrupt = true;
                            break;
                        }
                    }
                }
                if ($isCorrupt) {
                    Cache::forget($key);
                    $value = null;
                }
            }
            if ($value === null) {
                $value = $callback();
                if ($value !== null) {
                    Cache::put($key, $value, $ttl);
                }
            }
            return $value;
        } catch (\Throwable $e) {
            try {
                Cache::forget($key);
            } catch (\Throwable $ignored) {}
            return $callback();
        }
    }
}

if (!function_exists('setting')) {
    /**
     * Get setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        try {
            $val = safeCache("setting.{$key}", 3600, function () use ($key, $default) {
                if (!Schema::hasTable('settings')) {
                    return $default;
                }
                $setting = Setting::where('key', $key)->first();
                return ($setting && !is_null($setting->value) && $setting->value !== '') ? $setting->value : $default;
            });

            // Self-correct legacy instagram handle & URL automatically
            if ($key === 'social_instagram' && (empty($val) || str_contains($val, 'storyloom.in'))) {
                return 'https://www.instagram.com/storyloombooks/';
            }
            if ($key === 'instagram_username' && (empty($val) || $val === 'storyloom.in')) {
                return 'storyloombooks';
            }

            return $val;
        } catch (\Throwable $e) {
            if ($key === 'social_instagram') return 'https://www.instagram.com/storyloombooks/';
            if ($key === 'instagram_username') return 'storyloombooks';
            return $default;
        }
    }
}
