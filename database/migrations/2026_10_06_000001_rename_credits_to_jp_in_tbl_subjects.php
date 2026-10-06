<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('tbl_subjects', 'credits') && !Schema::hasColumn('tbl_subjects', 'jp')) {
            Schema::table('tbl_subjects', function (Blueprint $table) {
                $table->renameColumn('credits', 'jp');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tbl_subjects', 'jp') && !Schema::hasColumn('tbl_subjects', 'credits')) {
            Schema::table('tbl_subjects', function (Blueprint $table) {
                $table->renameColumn('jp', 'credits');
            });
        }
    }
};
