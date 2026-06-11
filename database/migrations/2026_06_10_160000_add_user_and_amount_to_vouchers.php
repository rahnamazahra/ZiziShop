<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            // کوپن مخصوص یک کاربر (null = عمومی)
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            // تخفیف مبلغی ثابت (تومان) — جایگزین درصد در صورت تنظیم
            $table->unsignedBigInteger('amount')->nullable()->after('discount_percent');
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('amount');
        });
    }
};
