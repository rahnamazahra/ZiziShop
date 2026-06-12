<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // تاریخ پایان تخفیف — null یعنی تخفیف دائمی است تا وقتی discount > 0 باشد
            $table->timestamp('discount_until')->nullable()->after('discount');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('discount_until');
        });
    }
};
