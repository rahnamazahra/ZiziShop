<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['products', 'orders', 'custom_orders', 'vouchers'] as $tbl) {
            Schema::table($tbl, function (Blueprint $table) {
                $table->boolean('is_demo')->default(false)->index();
            });
        }
    }

    public function down(): void
    {
        foreach (['products', 'orders', 'custom_orders', 'vouchers'] as $tbl) {
            Schema::table($tbl, function (Blueprint $table) {
                $table->dropColumn('is_demo');
            });
        }
    }
};
