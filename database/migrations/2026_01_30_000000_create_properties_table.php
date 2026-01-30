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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 12, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('storeys');
            $table->integer('garages');
            $table->timestamps();

            $table->index('name');
            $table->index('price');
            $table->index(['bedrooms', 'bathrooms', 'storeys', 'garages'], 'property_search_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
