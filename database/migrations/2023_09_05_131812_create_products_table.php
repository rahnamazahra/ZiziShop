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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('عنوان');
            $table->string('price')->comment('قیمت');
            $table->unsignedInteger('count')->comment('تعداد');
            $table->boolean('healthy')->default('1')->comment('وضعیت سالم بودن');
            $table->boolean('published')->default('1')->comment('وضعیت انتشار');
            $table->json('feature')->comment('ویژگی ها');
            $table->foreignId('discount_id')->constrained();
            $table->foreignId('sub_category_id')->constrained();
            $table->text('description');
            $table->string('slug');
            $table->timestamps();
            $table->comment('محصولات');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }

};
