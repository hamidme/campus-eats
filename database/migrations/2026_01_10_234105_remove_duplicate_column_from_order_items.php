<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the confusing extra column
            $table->dropColumn('menu_item_name');
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // If we ever need to go back, add it again
            $table->string('menu_item_name')->nullable();
        });
    }
};
