<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // ONLY drop if it actually exists
            if (Schema::hasColumn('order_items', 'menu_item_name')) {
                $table->dropColumn('menu_item_name');
            }
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'menu_item_name')) {
                $table->string('menu_item_name')->nullable();
            }
        });
    }
};
