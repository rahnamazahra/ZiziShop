<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('order_date');
            $table->foreignId('address_id')->constrained();
            $table->string('order_status')->default('preparing');
            $table->string('payment_status');
            $table->timestamps();
        });
    }

};
