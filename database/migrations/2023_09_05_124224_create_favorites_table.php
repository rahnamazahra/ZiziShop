<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });
    }
};
