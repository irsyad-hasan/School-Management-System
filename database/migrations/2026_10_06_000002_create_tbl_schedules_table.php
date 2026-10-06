<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->foreignId('class_id')->constrained('tbl_classes', 'class_id')->restrictOnDelete();
            $table->foreignId('teacher_id')->constrained('tbl_teachers', 'teacher_id')->restrictOnDelete();
            $table->foreignId('subject_id')->constrained('tbl_subjects', 'subject_id')->restrictOnDelete();
            $table->enum('day', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']);
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedTinyInteger('jp')->default(1);
            $table->boolean('archived')->default(false);
            $table->timestamps();
            $table->index(['class_id','day','start_time']);
            $table->index(['teacher_id','day','start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_schedules');
    }
};
