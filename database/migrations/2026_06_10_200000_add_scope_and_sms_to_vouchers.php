<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            // دامنه‌ی محصول: null = همه‌ی محصولات، در غیر این صورت فقط این محصول
            $table->foreignId('product_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            // لاگ ارسال پیامک کوپن
            $table->boolean('sms_sent')->default(false)->after('remaining');
            $table->timestamp('sms_sent_at')->nullable()->after('sms_sent');
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_id');
            $table->dropColumn(['sms_sent', 'sms_sent_at']);
        });
    }
};
