<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->string('postal_code')->nullable();
            $table->string('mobile');
            $table->string('receiver');
            $table->foreignId('city_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }
};
