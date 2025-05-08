<?php

namespace App\Services\Common;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class MediaService
{
    /**
     * Upload a file to the given folder on the given disk,
     * using a slugged, timestamped filename.
     *
     * @param  UploadedFile  $file
     * @param  string        $folder  e.g. 'products' or 'ar-models'
     * @param  string        $disk    filesystem disk (default: 's3')
     * @return string                 The stored filename (no folder prefix)
     *
     * @throws RuntimeException       If the upload fails
     */
    public static function upload(UploadedFile $file, string $folder, string $disk = 's3'): string
    {
        $base = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = sprintf(
            '%s_%s.%s',
            time(),
            Str::slug($base),
            $file->getClientOriginalExtension()
        );

        $path = trim($folder, '/').'/'.$filename;

        try {
            Storage::disk($disk)
                   ->putFileAs(trim($folder, '/'), $file, $filename);
        } catch (\Throwable $e) {
            Log::error('MediaService::upload failed', [
                'disk'     => $disk,
                'folder'   => $folder,
                'filename' => $filename,
                'error'    => $e->getMessage(),
            ]);

            throw new RuntimeException('Failed to upload file.');
        }

        return $filename;
    }

    /**
     * Delete a file by filename from the given folder on the given disk.
     *
     * @param  string  $filename  The filename to delete (no folder prefix)
     * @param  string  $folder    The folder where the file lives
     * @param  string  $disk      filesystem disk (default: 's3')
     * @return bool               True if deletion succeeded
     */
    public static function delete(string $filename, string $folder, string $disk = 's3'): bool
    {
        $path = trim($folder, '/').'/'.$filename;

        try {
            return Storage::disk($disk)->delete($path);
        } catch (\Throwable $e) {
            Log::warning('MediaService::delete failed', [
                'disk'     => $disk,
                'folder'   => $folder,
                'filename' => $filename,
                'error'    => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Generate a public URL for a file in the given folder on the given disk.
     *
     * @param  string  $filename  The filename to link to (no folder prefix)
     * @param  string  $folder    The folder where the file lives
     * @param  string  $disk      filesystem disk (default: 's3')
     * @return string             The full HTTPS URL
     *
     * @throws RuntimeException   If URL generation fails
     */
    public static function url(string $filename, string $folder, string $disk = 's3'): string
    {
        $path = trim($folder, '/').'/'.$filename;

        try {
            return Storage::disk($disk)->url($path);
        } catch (\Throwable $e) {
            Log::error('MediaService::url failed', [
                'disk'     => $disk,
                'folder'   => $folder,
                'filename' => $filename,
                'error'    => $e->getMessage(),
            ]);

            throw new RuntimeException('Failed to generate file URL.');
        }
    }
}
