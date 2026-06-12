<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // زمان ثبت تاریخ تولد — برای جلوگیری از ثبت تولد «همین فردا» و گرفتن فوری هدیه
            $table->timestamp('birthday_set_at')->nullable()->after('birthday');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthday_set_at');
        });
    }
};
