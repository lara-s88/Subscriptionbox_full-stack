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
                  ->unique()
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('plan_id')
                  ->constrained('plans')
                  ->cascadeOnDelete();

            $table->enum('status', ['active', 'paused', 'cancelled'])
                  ->default('active');

            $table->date('last_billing_date')->nullable();
            $table->date('next_billing_date');
            $table->date('pause_until');
            $table->timestamp('started_at')->useCurrent();

            $table->unsignedTinyInteger('renewal_day');

            $table->timestamps();
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
