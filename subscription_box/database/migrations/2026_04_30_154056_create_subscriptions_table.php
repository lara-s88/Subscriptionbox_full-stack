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
    Schema::create('subscriptions', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('plan_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->enum('status', ['active', 'paused', 'cancelled', 'pending'])
              ->default('pending');

        $table->date('next_billing_date')->nullable();
        $table->date('last_billing_date')->nullable();
        $table->date('pause_until')->nullable();
        $table->date('started_at')->nullable();

        $table->integer('renewal_day')->nullable();

        $table->timestamps(); // created_at + updated_at
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
