<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('plans', function (Blueprint $table) {
        $table->id();

        $table->string('name')->unique();
        $table->decimal('price_monthly', 10, 2);

        $table->integer('boxes_per_month')->default(1);
        $table->integer('swap_limit')->nullable();

        $table->boolean('express_shipping')->default(false);
        $table->boolean('early_access')->default(false);
        $table->boolean('vip_support')->default(false);

      
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
