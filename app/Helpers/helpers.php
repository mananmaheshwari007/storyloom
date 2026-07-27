<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

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
            $val = Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
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
        } catch (\Exception $e) {
            if ($key === 'social_instagram') return 'https://www.instagram.com/storyloombooks/';
            if ($key === 'instagram_username') return 'storyloombooks';
            return $default;
        }
    }
}
