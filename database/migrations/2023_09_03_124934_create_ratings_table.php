<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{

    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->morphs('rateable');
            $table->foreignId('user_id')->constrained();
            $table->index(['rateable_id', 'rateable_type']);
        });
    }

}
