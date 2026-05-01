<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('box_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('box_id')
                  ->constrained('boxes')
                  ->cascadeOnDelete();

            $table->foreignId('inventory_item_id')
                  ->constrained('inventory_items')
                  ->cascadeOnDelete();

            $table->boolean('is_part_of_box')
                  ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('box_items');
    }
};