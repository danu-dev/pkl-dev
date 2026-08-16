<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadCv(UploadedFile $file): string
    {
        return $file->store('cv_files', 'public');
    }

    public function uploadImage(UploadedFile $file, string $folder = 'landing'): string
    {
        return $file->store($folder, 'public');
    }

    public function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
