<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // قیمت تمام‌شده‌ی واقعی محصول؛ فقط برای محاسبه‌ی سود در پنل و هرگز به کاربر نمایش داده نمی‌شود
            $table->unsignedBigInteger('cost_price')->nullable()->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('cost_price');
        });
    }
};
