<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->text('path');
            $table->unsignedInteger('size');
            $table->string('mime_type');
            $table->morphs('model');
        });
    }
};
