<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // allow guest carts (no user)
        DB::statement('ALTER TABLE carts MODIFY user_id BIGINT UNSIGNED NULL');

        Schema::table('carts', function (Blueprint $table) {
            if (! Schema::hasColumn('carts', 'session_token')) {
                $table->string('session_token')->nullable()->index()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn('carts', 'session_token')) {
                $table->dropColumn('session_token');
            }
        });
    }
};
