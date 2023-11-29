<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->text('gateway_ref')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('address_id')->nullable()->constrained();
            $table->foreignId('voucher_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

};
