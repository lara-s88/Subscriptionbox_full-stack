<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_batches', function (Blueprint $table) {
            $table->id();

            $table->string('batch_code', 50)->unique();
            $table->string('region', 100);

            $table->enum('warehouse_state', [
                'picking',
                'packed',
                'shipped'
            ])->default('picking');

            $table->date('scheduled_ship_date')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_batches');
    }
};