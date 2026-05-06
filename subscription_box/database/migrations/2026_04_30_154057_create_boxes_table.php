<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();



            $table->string('name', 150);
            $table->string('box_type', 80);
            $table->decimal('base_price', 10, 2);

            $table->string('base_image', 255)->nullable();
            $table->text('description')->nullable();
            $table->decimal('weight_kg', 8, 2)->default(0.00);

            $table->boolean('is_active')
                  ->default(true);

             });
    }


    public function down(): void
    {
        Schema::dropIfExists('boxes');
    }
};
