<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            // قیمت اختصاصی هر تنوع (سایز/رنگ). در نبودِ آن، قیمت پایه‌ی محصول معیار است.
            $table->unsignedBigInteger('price')->nullable()->after('size_id');
        });
    }

    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
