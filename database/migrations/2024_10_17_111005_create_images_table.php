<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id(); // حقل id تلقائي الزيادة
            $table->string('name'); // اسم الصورة
            $table->string('path'); // مسار الصورة
            $table->string('mime_type'); // نوع MIME
            $table->string('alt_text')->nullable(); // نص بديل للصورة
            $table->timestamps(); // حقل timestamps لإضافة created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
