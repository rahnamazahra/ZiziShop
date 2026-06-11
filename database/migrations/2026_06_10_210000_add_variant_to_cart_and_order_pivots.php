<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->foreignId('stock_id')->nullable()->after('product_id');
        });

        Schema::table('order_product', function (Blueprint $table) {
            $table->foreignId('color_id')->nullable()->after('product_id');
            $table->foreignId('size_id')->nullable()->after('color_id');
        });
    }

    public function down(): void
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->dropColumn('stock_id');
        });
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropColumn(['color_id', 'size_id']);
        });
    }
};
