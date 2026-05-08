<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

                $table->foreignId('plan_id')
                ->constrained('plans');
              

            $table->enum('diet_preference', [
                'standard',
                'keto',
                'vegan',
                'Hiegh Protein',
            ])->nullable();

            $table->enum('delivery_frequency', [
                'Monthly',
                'Bi_Monthly',
                'Quarterly',
            ])->nullable();

            $table->enum('clothing_size', [
                'XS',
                'S',
                'M',
                'L',
                'XL',
                'XXL',
            ])->nullable();

            $table->string('address', 190)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->text('delivery_instructions')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
