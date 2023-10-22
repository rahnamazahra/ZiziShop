<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique()->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('barcode')->unique()->nullable();
            $table->foreignId('category_id')->constrained();
            $table->unsignedInteger('price');
            $table->unsignedInteger('discount')->default(0);
            $table->text('description')->nullable();
            $table->unsignedInteger('inventory')->default(0);
            $table->boolean('is_healthy')->default(true);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('weight')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('Height')->nullable();
            $table->unsignedInteger('length')->nullable();
            $table->json('features')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

};
