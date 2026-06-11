<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');                               // نام متریال
            $table->string('color')->nullable();                  // رنگ متریال
            $table->unsignedInteger('quantity')->default(1);      // تعداد
            $table->unsignedInteger('weight')->nullable();        // وزن (گرم)
            $table->unsignedBigInteger('unit_price')->default(0); // قیمت هر واحد (تومان)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_materials');
    }
};
