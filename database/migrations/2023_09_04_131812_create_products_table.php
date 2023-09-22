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
            $table->unsignedInteger('price');
            $table->unsignedInteger('count');
            $table->boolean('healthy')->default('1');
            $table->boolean('published')->default('1');
            $table->json('feature');
            $table->foreignId('discount_id');
            $table->foreignId('sub_category_id');
            $table->text('description');
            $table->string('slug');
            $table->softDeletes();
        });
    }

};
