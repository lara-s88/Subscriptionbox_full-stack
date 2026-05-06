<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();


            $table->string('name', 150);
            $table->string('category', 80);

            $table->integer('stock_qty');
            $table->integer('safety_threshold')->default(0);

            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->decimal('weight_kg', 8, 2)->default(0.00);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};