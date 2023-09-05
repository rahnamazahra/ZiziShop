<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_size', function (Blueprint $table) {
            $table->id()->comment('شناسه');
            $table->unsignedBigInteger('product_id')->comment('شناسه محصول');
            $table->unsignedBigInteger('size_id')->comment('شناسه رنگ');
            $table->unsignedInteger('count')->comment('تعداد');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_size');
    }
};
