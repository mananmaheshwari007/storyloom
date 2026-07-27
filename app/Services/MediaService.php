<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * Upload and optimize image to WebP.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param int $quality
     * @return string Filepath relative to public storage disk
     */
    public static function uploadAndOptimize(UploadedFile $file, string $folder = 'uploads', int $quality = 75): string
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $cleanFilename = Str::slug($filename) . '-' . time() . '.webp';
        $path = "{$folder}/{$cleanFilename}";

        // Optimize and convert to WebP using GD library
        $imageInfo = @getimagesize($file->getRealPath());
        $mime = $imageInfo['mime'] ?? '';

        ob_start();
        $image = null;
        
        switch ($mime) {
            case 'image/jpeg':
                $image = @imagecreatefromjpeg($file->getRealPath());
                break;
            case 'image/png':
                $image = @imagecreatefrompng($file->getRealPath());
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'image/gif':
                $image = @imagecreatefromgif($file->getRealPath());
                break;
            case 'image/webp':
                $image = @imagecreatefromwebp($file->getRealPath());
                break;
        }

        if ($image) {
            @imagewebp($image, null, $quality);
            $webpData = ob_get_clean();
            @imagedestroy($image);
            
            Storage::disk('public')->put($path, $webpData);
            
            $fileSize = Storage::disk('public')->size($path);
            $fileType = 'image/webp';
        } else {
            ob_end_clean();
            // fallback: upload raw if GD fails
            $extension = $file->getClientOriginalExtension();
            $cleanFilename = Str::slug($filename) . '-' . time() . '.' . $extension;
            $path = "{$folder}/{$cleanFilename}";
            Storage::disk('public')->putFileAs($folder, $file, $cleanFilename);
            
            $fileSize = $file->getSize();
            $fileType = $file->getClientMimeType();
        }

        // Add entry to Media table for the Media Manager
        Media::create([
            'filename' => $cleanFilename,
            'filepath' => $path,
            'file_size' => self::formatBytes($fileSize),
            'file_type' => $fileType,
            'folder' => $folder
        ]);

        return $path;
    }

    /**
     * Delete file from storage.
     *
     * @param string $path
     * @return bool
     */
    public static function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            // Delete database entry if exists
            Media::where('filepath', $path)->delete();
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    /**
     * Format file size.
     */
    private static function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
