<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // user
            // amount
            // gateway
            // tracking code
            // card number
            $table->timestamps();
        });
    }

};
