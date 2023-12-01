<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{

    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('rating'); //Todo replace score
            $table->text('comment')->nullable();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unique(['user_id', 'product_id']);
            $table->timestamps();
        });
    }

}
