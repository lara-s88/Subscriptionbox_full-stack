<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            $table->foreignId('batch_id')
                  ->nullable()
                  ->constrained('shipping_batches')
                  ->nullOnDelete();

            $table->string('tracking_code', 80)->unique();
            $table->string('carrier_name', 100)->nullable();

            $table->enum('status', [
                'pending',
                'picking',
                'packed',
                'shipped',
                'out_for_delivery',
                'delivered'
            ])->default('pending');

            $table->date('estimated_delivery')->nullable();
            $table->integer('stops_away')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};