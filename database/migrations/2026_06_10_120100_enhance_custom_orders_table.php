<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تکمیل جدول سفارش‌های ویژه برای جریان: ثبت کاربر → بررسی/تأیید ادمین (قیمت‌گذاری) → پرداخت کاربر
     */
    public function up(): void
    {
        Schema::table('custom_orders', function (Blueprint $table) {
            // قیمت واحدی که ادمین هنگام تأیید تعیین می‌کند (به تومان)
            $table->unsignedBigInteger('unit_price')->nullable()->after('quantity');
            // یادداشت ادمین برای کاربر (دلیل رد یا توضیح تأیید)
            $table->text('admin_note')->nullable()->after('unit_price');
            // ارجاع پرداخت درگاه
            $table->string('gateway_ref')->nullable()->after('admin_note');
            // زمان پرداخت موفق
            $table->timestamp('paid_at')->nullable()->after('gateway_ref');
            // سفارش نهایی که پس از پرداخت ساخته می‌شود
            $table->foreignId('order_id')->nullable()->after('paid_at')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('custom_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('order_id');
            $table->dropColumn(['unit_price', 'admin_note', 'gateway_ref', 'paid_at']);
        });
    }
};
