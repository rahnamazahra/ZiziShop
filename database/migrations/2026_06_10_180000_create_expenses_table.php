<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');                                  // عنوان هزینه
            $table->string('type')->default('other');                 // نوع هزینه (hosting, sms, material, ...)
            $table->unsignedBigInteger('amount');                     // مبلغ (تومان)
            $table->date('spent_at');                                 // تاریخ پرداخت
            $table->string('recurrence')->default('once');            // تناوب: once|monthly|quarterly|biannual|yearly
            $table->text('description')->nullable();                  // توضیحات

            // مخصوص خرید اجناس/متریال
            $table->string('material_name')->nullable();
            $table->string('product_code')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->unsignedInteger('weight')->nullable();            // گرم

            $table->boolean('is_demo')->default(false);               // مورد تستی/نمایشی
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
