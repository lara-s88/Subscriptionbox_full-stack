<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PlanSeeder;
use Database\Seeders\BoxSeeder;
use Database\Seeders\RewardItemSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
            BoxSeeder::class,
            RewardItemSeeder::class,
        ]);
    }
}
