<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_users', function (Blueprint $table) {
            $table->timestamp('first_login_at')->nullable()->after('archived');
        });

        // Semua akun yang sudah ada dianggap sebagai akun lama.
        DB::table('tbl_users')
            ->whereNull('first_login_at')
            ->update(['first_login_at' => DB::raw('created_at')]);
    }

    public function down(): void
    {
        Schema::table('tbl_users', function (Blueprint $table) {
            $table->dropColumn('first_login_at');
        });
    }
};
