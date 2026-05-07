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
        Schema::create('themes_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')
            ->constrained('themes')
            ->cascadeOnDelete();

            $table->foreignId('inventory_item_id')
            ->constrained('inventory_items')
            ->cascadeOnDelete();

            $table->unique(['theme_id', 'inventory_item_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes_items');
    }
};
