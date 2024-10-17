<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Models\Image; 

class AssetsService 
{
    public function storeImage($image) // هنا، $image هو كائن UploadedFile
    {
        // استخدم الكائن $image مباشرة
        $originalName = $image->getClientOriginalName();

        // التأكد من أن اسم الملف لا يحتوي على نقاط غير مسموح بها
        if (preg_match('/\.\.+/', $originalName)) {
            throw new Exception(trans('general.notAllowedAction'), 403);
        }

        // Check for path traversal attack (e.g., using ../ or ..\ or / to go up directories)
        if (strpos($originalName, '..') !== false || strpos($originalName, '/') !== false || strpos($originalName, '\\') !== false) {
            throw new Exception(trans('general.pathTraversalDetected'), 403);
        }

        // Validate the MIME type to ensure it's an image
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $mime_type = $image->getClientMimeType();

        if (!in_array($mime_type, $allowedMimeTypes)) {
            throw new FileException(trans('general.invalidFileType'), 403);
        }

        // توليد اسم ملف عشوائي وآمن
        $fileName = Str::random(32);
        $extension = $image->getClientOriginalExtension(); // Safe way to get file extension
        $filePath = "Images/{$fileName}.{$extension}";

        // تخزين الملف بشكل آمن
        $path = Storage::disk('local')->putFileAs('Images', $image, "{$fileName}.{$extension}");

        // احصل على المسار الكامل لملف الصورة المخزنة
        $url = Storage::disk('local')->url($path);

        // تخزين بيانات الصورة في قاعدة البيانات
        $savedImage = Image::create([
            'name' => $originalName, // يمكنك تخصيص الاسم هنا حسب الحاجة
            'path' => $url,
            'mime_type' => $mime_type,
            'alt_text' => null, // إذا كنت لا تستخدم alt_text، اجعلها null أو أضفها من $imageDTO إذا كان ذلك مناسبًا
        ]);

        return $savedImage; // قم بإرجاع الصورة المخزنة
    }
}
