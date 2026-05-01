<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_item_extras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cart_item_id')
                  ->constrained('cart_items')
                  ->cascadeOnDelete();

            $table->foreignId('inventory_item_id')
                  ->nullable()
                  ->constrained('inventory_items')
                  ->nullOnDelete();

            $table->string('item_name', 150);

            $table->enum('source_type', [
                'default',
                'swap',
                'addon',
                'surprise'
            ])->default('default');

            $table->decimal('unit_price', 10, 2)->default(0.00);

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_item_extras');
    }
};