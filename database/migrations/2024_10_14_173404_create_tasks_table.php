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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['Bug', 'Feature', 'Improvement']);
            $table->enum('status', ['Open', 'In Progress', 'Completed', 'Blocked'])->default('Open');
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->timestamps();
    
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
