<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 
        public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add a decimal column for money (default 0.00)
            $table->decimal('wallet_balance', 10, 2)->default(0.00)->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('wallet_balance');
        });
    }
};
