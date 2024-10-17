<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attachment\AttachmentRequest; // استيراد طلب التحقق من بيانات المرفقات
use App\Models\Task; // استيراد نموذج المهمة
use App\Http\Services\AssetsService; // استيراد خدمة AssetsService
use Illuminate\Support\Facades\Log; // استيراد وظيفة تسجيل الأخطاء
use Illuminate\Database\Eloquent\ModelNotFoundException; // استيراد استثناء عدم العثور على نموذج
use Illuminate\Database\Eloquent\RelationNotFoundException; // استيراد استثناء عدم العثور على علاقة

class AttachmentController extends Controller // تعريف الفئة AttachmentController
{
    protected $assetsService; // تعريف خاصية لحفظ خدمة AssetsService

    // حقن خدمة AssetsService عبر الـ Constructor
    public function __construct(AssetsService $assetsService)
    {
        $this->assetsService = $assetsService; // تخزين الخدمة في الخاصية
    }

    // دالة لتخزين المرفق
    public function store(AttachmentRequest $request, Task $task)
    {
        try {
            // استدعاء الدالة storeImage لتخزين الصورة
            $image = $this->assetsService->storeImage($request->file('attachment'), $task);

            // إنشاء سجل جديد في علاقة المرفقات بالمهمة مع البيانات المستخرجة
            $attachment = $task->attachments()->create([
                'file_name' => $image->name, // اسم الملف
                'file_path' => $image->path, // مسار الملف
            ]);

            // إرجاع استجابة JSON تحتوي على بيانات المرفق الجديد مع حالة نجاح 201
            return response()->json($attachment, 201);
        } catch (\Exception $e) {
            // تسجيل الخطأ في السجلات إذا تمت مواجهة استثناء عام
            Log::error($e);
            return response()->json('Something went wrong', 500); // إرجاع استجابة خطأ
        } catch (ModelNotFoundException $e) {
            // تسجيل الخطأ في السجلات إذا تمت مواجهة استثناء عدم العثور على نموذج
            Log::error($e);
            return response()->json('We didn\'t find anything', 404); // إرجاع استجابة عدم العثور
        } catch (RelationNotFoundException $e) {
            // تسجيل الخطأ في السجلات إذا تمت مواجهة استثناء عدم العثور على علاقة
            Log::error($e);
            return response()->json('We didn\'t find any relation', 404); // إرجاع استجابة عدم العثور على العلاقة
        }
    }
}
