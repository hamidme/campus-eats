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
        Schema::create('menu_variants', function (Blueprint $table) {
            $table->id();
            
            // Link to the Parent Food
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade');
            
            // e.g., "Single Plate", "Family Pot", "1 Liter Bowl"
            $table->string('name'); 
            
            // e.g., 15.00, 120.00
            $table->decimal('price', 8, 2);
            
            // Optional: "Feeds 1 person", "Lasts 1 week"
            $table->string('capacity_info')->nullable(); 
            
            // Each size can be Sold Out individually!
            $table->boolean('is_available')->default(true);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_variants');
    }
};
