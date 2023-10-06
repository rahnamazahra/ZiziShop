<?php

use Carbon\Doctrine\CarbonType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('comment');
            $table->unsignedInteger('discount');
            $table->unsignedInteger('post_discount');
            $table->unsignedInteger('mininum_purchase_total');
            $table->unsignedInteger('maximum_discount');
            $table->unsignedInteger('maximum_post_discount');
            $table->date('start_date');
            $table->date('end_date');
            $table->softDeletes();
            $table->timestamps();

        });
    }

};
