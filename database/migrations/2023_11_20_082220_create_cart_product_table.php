<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('cart_product', function (Blueprint $table) {
            $table->foreignId('cart_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->unsignedInteger('count')->default(1);
        });
    }

};
