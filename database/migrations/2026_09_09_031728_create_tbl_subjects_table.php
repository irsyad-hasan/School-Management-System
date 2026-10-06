<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_subjects', function (Blueprint $table) {
            $table->id('subject_id');
            $table->string('subject_name', 100);
            $table->string('subject_code', 20)->unique();
            $table->unsignedInteger('jp');
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_subjects');
    }
};