<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_students', function (Blueprint $table) {
            $table->id('student_id');

            $table->foreignId('user_id')
                ->unique()
                ->constrained('tbl_users', 'user_id')
                ->cascadeOnDelete();

            $table->string('full_name', 100);
            $table->string('nis', 30)->unique();

            $table->foreignId('class_id')
                ->constrained('tbl_classes', 'class_id')
                ->restrictOnDelete();

            $table->date('date_of_birth');

            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_students');
    }
};