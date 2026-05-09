<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('box_orders', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
        
            $table->foreignId('box_id')
                  ->constrained('boxes')
                  ->cascadeOnDelete();

           
            $table->string('order_number')->unique();
            $table->string('box_name');
            $table->string('clothing_size')->nullable();
            $table->string('diet_preference')->nullable();
            $table->string('delivery_frequency')->nullable();
            
            $table->enum('status', [
                'pending',
                'packed',
                'shipped',
                'out_for_delivery',
                'delivered',
                'returned'
            ])->default('pending');
            
            $table->decimal('total_amount', 10, 2);
            
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('box_orders');
    }
};
