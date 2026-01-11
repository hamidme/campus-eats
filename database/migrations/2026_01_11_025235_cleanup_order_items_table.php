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
        
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // If we ever roll back, put it back
            $table->string('menu_item_name')->nullable();
        });
    }
};
