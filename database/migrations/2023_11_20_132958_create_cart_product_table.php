<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('cart_product', function (Blueprint $table) {
            $table->text('gateway_ref');
            $table->foreignId('cart_id')->constrained();
            $table->foreignId('product_id')->nullable()->constrained();
            $table->unsignedInteger('count')->default(1);
        });
    }

};
