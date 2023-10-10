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
            $table->string('comment')->nullable();
            $table->unsignedInteger('discount');
            $table->unsignedInteger('shipping_discount');
            $table->unsignedInteger('mininum_purchase_total')->nullable();
            $table->unsignedInteger('maximum_discount')->nullable();
            $table->unsignedInteger('maximum_shipping_discount')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('remaining')->default(1);
            $table->softDeletes();
            $table->timestamps();

        });
    }

};
