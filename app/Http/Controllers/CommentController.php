<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentRequest; // استيراد طلب التحقق من بيانات التعليق
use App\Models\Comment; // استيراد نموذج التعليق
use App\Models\Task; // استيراد نموذج المهمة
use Illuminate\Http\Request; // استيراد طلب HTTP
use Illuminate\Support\Facades\Log; // استيراد وظيفة تسجيل الأخطاء
use Illuminate\Support\Facades\Auth; // استيراد واجهة المصادقة

class CommentController extends Controller // تعريف الفئة CommentController
{
    // دالة لتخزين التعليق
    public function store(CommentRequest $request, Task $task)
    {   
        try {
            // إنشاء تعليق جديد مرتبط بالمهمة الحالية
            $comment = $task->comments()->create([
                'user_id' => Auth::id(), // الحصول على معرف المستخدم الحالي
                'content' => $request->content, // محتوى التعليق المُرسل في الطلب
            ]);

            // إرجاع استجابة JSON تحتوي على بيانات التعليق الجديد مع حالة نجاح 201
            return response()->json($comment, 201);
        } catch (ModelNotFoundException $e) {
            // تسجيل الخطأ في السجلات إذا تمت مواجهة استثناء عدم العثور على نموذج
            Log::error($e);
            return response()->json('We didn\'t find anything', 404); // إرجاع استجابة عدم العثور
        } catch (RelationNotFoundException $e) {
            // تسجيل الخطأ في السجلات إذا تمت مواجهة استثناء عدم العثور على علاقة
            Log::error($e);
            return response()->json('We didn\'t find any relation', 404); // إرجاع استجابة عدم العثور على العلاقة
        } catch (\Exception $e) {
            // تسجيل الخطأ في السجلات إذا تمت مواجهة استثناء عام
            Log::error($e);
            return response()->json('Something went wrong', 500); // إرجاع استجابة خطأ
        } 
    }
}
