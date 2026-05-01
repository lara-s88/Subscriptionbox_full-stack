<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('box_id')
                  ->constrained('boxes')
                  ->cascadeOnDelete();

            $table->string('custom_size', 20)->nullable();
            $table->string('diet_preference', 100)->nullable();

            $table->enum('shipping_status', [
                'pending_confirmation',
                'shipping_confirmed',
                'shipped'
            ])->default('pending_confirmation');

            $table->decimal('subtotal', 10, 2)->default(0.00);

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};