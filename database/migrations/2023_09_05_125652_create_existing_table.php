<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('existing', function (Blueprint $table) {
            $table->id();
            $table->string('mobile');
            $table->foreignId('product_id')->constrained();
        });
    }

};
