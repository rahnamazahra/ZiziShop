<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id()->comment('شناسه');
            $table->string('file_name')->comment('نام');
            $table->text('path')->comment('مسیر');
            $table->string('size')->comment('حجم');
            $table->string('mime_type')->comment('نوع');
            $table->morphs('fileable');
            $table->timestamps();
            $table->comment('فایل ها');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
