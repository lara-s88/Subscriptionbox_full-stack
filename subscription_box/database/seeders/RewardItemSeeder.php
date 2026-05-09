<?php

namespace Database\Seeders;

use App\Models\RewardItem;
use Illuminate\Database\Seeder;

class RewardItemSeeder extends Seeder
{
    public function run(): void
    {
        $rewards = [
            [
                'name' => 'Free Shipping',
                'description' => 'One free shipping on next box',
                'points' => 5,
                'icon' => 'bi-truck',
            ],
            [
                'name' => 'Box Discount',
                'description' => '$10 off next subscription box',
                'points' => 10,
                'icon' => 'bi-tag',
            ],
            [
                'name' => 'Priority Access',
                'description' => 'Early access to new items',
                'points' => 15,
                'icon' => 'bi-lightning',
            ],
            [
                'name' => 'Exclusive Gear',
                'description' => 'Limited edition SportBox merchandise',
                'points' => 25,
                'icon' => 'bi-gift',
            ],
        ]; 

        foreach ($rewards as $reward) {
            RewardItem::updateOrCreate(
                ['name' => $reward['name']],
                $reward + ['is_active' => true]
            );
        }
    }
}
