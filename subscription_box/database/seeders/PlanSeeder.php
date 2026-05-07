<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'Basic',
            'price_monthly' => 29,
            'boxes_per_month' => 1,
            'swap_limit' => 3,
            'express_shipping' => false,
            'early_access' => false,
            'vip_support' => false,
        ]);

        Plan::create([
            'name' => 'Pro',
            'price_monthly' => 49,
            'boxes_per_month' => 2,
            'swap_limit' => null,
            'express_shipping' => true,
            'early_access' => true,
            'vip_support' => true,
        ]);

        Plan::create([
            'name' => 'VIP',
            'price_monthly' => 89,
            'boxes_per_month' => 3,
            'swap_limit' => null,
            'express_shipping' => true,
            'early_access' => true,
            'vip_support' => true,
        ]);
    }
}