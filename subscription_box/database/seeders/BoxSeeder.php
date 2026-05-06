<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    

 public function run(){
    DB::table('boxes')->insert([
        'id' => 1,
        'theme_id' => 1,
        'name' => 'Football Box',
        'box_type' => 'standard',
        'base_price' => 300,
        'is_active' => 1,
        'created_at' => now()
    ]);

    DB::table('inventory_items')->insert([
        [
            'id' => 1,
            'theme_id' => 1,
            'name' => 'Football',
            'category' => 'sports',
            'stock_qty' => 10,
            'unit_price' => 100
        ],
        [
            'id' => 2,
            'theme_id' => 1,
            'name' => 'Gloves',
            'category' => 'sports',
            'stock_qty' => 5,
            'unit_price' => 50
        ]
    ]);

    DB::table('box_items')->insert([
        [
            'box_id' => 1,
            'inventory_item_id' => 1,
            'is_part_of_box' => 1
        ],
        [
            'box_id' => 1,
            'inventory_item_id' => 2,
            'is_part_of_box' => 1
        ]
    ]);
}
}
