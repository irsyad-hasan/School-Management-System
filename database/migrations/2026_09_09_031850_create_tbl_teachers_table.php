<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_teachers', function (Blueprint $table) {
            $table->id('teacher_id');

            $table->foreignId('user_id')
                ->unique()
                ->constrained('tbl_users', 'user_id')
                ->cascadeOnDelete();

            $table->string('full_name', 100);
            $table->string('nip', 30)->unique();

            $table->foreignId('subject_id')
                ->constrained('tbl_subjects', 'subject_id')
                ->restrictOnDelete();

            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_teachers');
    }
};