<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('subscription_id')
                  ->nullable()
                  ->constrained('subscriptions')
                  ->nullOnDelete();

            $table->foreignId('cart_item_id')
                  ->nullable()
                  ->constrained('cart_items')
                  ->nullOnDelete();

            $table->string('order_number', 50)->unique();

            $table->enum('status', [
                'pending',
                'picking',
                'packed',
                'shipped',
                'out_for_delivery',
                'delivered',
                'returned'
            ])->default('pending');

            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->decimal('shipping_fee', 10, 2)->default(0.00);

            $table->dateTime('confirmed_at')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};