<?php

namespace App\Services\Common;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    protected string $disk;
    protected string $prefix;

    /**
     * MediaService constructor.
     *
     * @param string $disk   The filesystem disk to use (e.g., 's3')
     * @param string $prefix The folder prefix inside the disk (e.g., 'products')
     */
    public function __construct(string $disk = 's3', string $prefix = 'products')
    {
        $this->disk   = $disk;
        $this->prefix = trim($prefix, '/');
    }

    /**
     * Upload an UploadedFile to the configured disk with a slugged, timestamped filename.
     *
     * @param UploadedFile $file
     * @return string             The stored filename (without prefix)
     * @throws \Exception        If the upload fails
     */
    public function upload(UploadedFile $file): string
    {
        $name = time()
              . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
              . '.' . $file->getClientOriginalExtension();

        $path = ($this->prefix ? $this->prefix . '/' : '') . $name;

        // Store the file on the chosen disk
        Storage::disk($this->disk)->putFileAs(
            $this->prefix,
            $file,
            $name
        );

        return $name;
    }

    /**
     * Delete a file by its filename from the configured disk.
     *
     * @param string $filename  The filename to delete (without prefix)
     * @return bool             True if deletion succeeded
     */
    public function delete(string $filename): bool
    {
        $path = ($this->prefix ? $this->prefix . '/' : '') . $filename;
        return Storage::disk($this->disk)->delete($path);
    }

    /**
     * Generate a publicly accessible URL for a stored file.
     *
     * @param string $filename  The filename to generate a URL for
     * @return string           The full URL to the resource
     */
    public function url(string $filename): string
    {
        $path = ($this->prefix ? $this->prefix . '/' : '') . $filename;
        return Storage::disk($this->disk)->url($path);
    }
}
