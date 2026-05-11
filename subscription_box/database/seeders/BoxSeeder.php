<?php

namespace Database\Seeders;

use App\Models\Box;
use App\Models\BoxItem;
use App\Models\InventoryItem;
use App\Models\Themes;
use App\Models\ThemesItem;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Football', 'category' => 'football', 'stock_qty' => 40, 'safety_threshold' => 8, 'unit_price' => 18, 'weight_kg' => 0.45],
            ['name' => 'Football Socks', 'category' => 'football', 'stock_qty' => 55, 'safety_threshold' => 10, 'unit_price' => 9, 'weight_kg' => 0.10],
            ['name' => 'Grip Gloves', 'category' => 'football', 'stock_qty' => 30, 'safety_threshold' => 6, 'unit_price' => 14, 'weight_kg' => 0.20],
            ['name' => 'Basketball', 'category' => 'basketball', 'stock_qty' => 35, 'safety_threshold' => 8, 'unit_price' => 22, 'weight_kg' => 0.60],
            ['name' => 'Wrist Bands', 'category' => 'basketball', 'stock_qty' => 60, 'safety_threshold' => 10, 'unit_price' => 7, 'weight_kg' => 0.05],
            ['name' => 'Training Cones', 'category' => 'basketball', 'stock_qty' => 45, 'safety_threshold' => 10, 'unit_price' => 12, 'weight_kg' => 0.35],
            ['name' => 'Resistance Bands', 'category' => 'gym', 'stock_qty' => 50, 'safety_threshold' => 12, 'unit_price' => 16, 'weight_kg' => 0.30],
            ['name' => 'Protein Bars', 'category' => 'gym', 'stock_qty' => 90, 'safety_threshold' => 20, 'unit_price' => 2.5, 'weight_kg' => 0.05],
            ['name' => 'Shaker Bottle', 'category' => 'gym', 'stock_qty' => 32, 'safety_threshold' => 8, 'unit_price' => 11, 'weight_kg' => 0.18],
            ['name' => 'Yoga Mat', 'category' => 'yoga', 'stock_qty' => 28, 'safety_threshold' => 6, 'unit_price' => 24, 'weight_kg' => 0.95],
            ['name' => 'Yoga Block Set', 'category' => 'yoga', 'stock_qty' => 36, 'safety_threshold' => 8, 'unit_price' => 13, 'weight_kg' => 0.32],
            ['name' => 'Stretch Strap', 'category' => 'yoga', 'stock_qty' => 44, 'safety_threshold' => 10, 'unit_price' => 8, 'weight_kg' => 0.12],
            ['name' => 'Running Belt', 'category' => 'running', 'stock_qty' => 34, 'safety_threshold' => 8, 'unit_price' => 15, 'weight_kg' => 0.16],
            ['name' => 'Cooling Towel', 'category' => 'running', 'stock_qty' => 52, 'safety_threshold' => 12, 'unit_price' => 10, 'weight_kg' => 0.11],
            ['name' => 'Reflective Arm Bands', 'category' => 'running', 'stock_qty' => 48, 'safety_threshold' => 10, 'unit_price' => 7, 'weight_kg' => 0.06],
            ['name' => 'Tennis Balls Pack', 'category' => 'tennis', 'stock_qty' => 65, 'safety_threshold' => 14, 'unit_price' => 9, 'weight_kg' => 0.18],
            ['name' => 'Tennis Grip Tape', 'category' => 'tennis', 'stock_qty' => 58, 'safety_threshold' => 12, 'unit_price' => 6, 'weight_kg' => 0.04],
            ['name' => 'Sweat Headband', 'category' => 'tennis', 'stock_qty' => 42, 'safety_threshold' => 10, 'unit_price' => 7, 'weight_kg' => 0.05],
            ['name' => 'Swim Goggles', 'category' => 'swimming', 'stock_qty' => 31, 'safety_threshold' => 7, 'unit_price' => 18, 'weight_kg' => 0.12],
            ['name' => 'Swim Cap', 'category' => 'swimming', 'stock_qty' => 47, 'safety_threshold' => 10, 'unit_price' => 8, 'weight_kg' => 0.05],
            ['name' => 'Microfiber Towel', 'category' => 'swimming', 'stock_qty' => 39, 'safety_threshold' => 9, 'unit_price' => 14, 'weight_kg' => 0.24],
            ['name' => 'Jump Rope', 'category' => 'boxing', 'stock_qty' => 45, 'safety_threshold' => 10, 'unit_price' => 12, 'weight_kg' => 0.20],
            ['name' => 'Hand Wraps', 'category' => 'boxing', 'stock_qty' => 50, 'safety_threshold' => 12, 'unit_price' => 9, 'weight_kg' => 0.10],
            ['name' => 'Mouth Guard', 'category' => 'boxing', 'stock_qty' => 38, 'safety_threshold' => 8, 'unit_price' => 11, 'weight_kg' => 0.04],
        ];

        foreach ($items as $item) {
            InventoryItem::updateOrCreate(['name' => $item['name']], $item);
        }

        $boxes = [
            [
                'name' => 'Football Starter Box',
                'box_type' => 'football',
                'base_price' => 20,
                'base_image' => 'https://images.pexels.com/photos/46798/the-ball-stadion-football-the-pitch-46798.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Core football gear for weekly play.',
                'items' => ['Football', 'Football Socks', 'Grip Gloves'],
            ],
            [
                'name' => 'Basketball Court Box',
                'box_type' => 'basketball',
                'base_price' => 25,
                'base_image' => 'https://images.pexels.com/photos/1752757/pexels-photo-1752757.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Basketball essentials for practice and pickup games.',
                'items' => ['Basketball', 'Wrist Bands', 'Training Cones'],
            ],
            [
                'name' => 'Gym Performance Box',
                'box_type' => 'gym',
                'base_price' => 30,
                'base_image' => 'https://images.pexels.com/photos/1552242/pexels-photo-1552242.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Training and recovery gear for fitness routines.',
                'items' => ['Resistance Bands', 'Protein Bars', 'Shaker Bottle'],
            ],
            [
                'name' => 'Yoga Recovery Box',
                'box_type' => 'yoga',
                'base_price' => 28,
                'base_image' => 'https://images.pexels.com/photos/3822622/pexels-photo-3822622.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Mobility and recovery essentials for yoga and stretching days.',
                'items' => ['Yoga Mat', 'Yoga Block Set', 'Stretch Strap'],
            ],
            [
                'name' => 'Runner Essentials Box',
                'box_type' => 'running',
                'base_price' => 24,
                'base_image' => 'https://images.pexels.com/photos/2402777/pexels-photo-2402777.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Lightweight accessories for safer and more comfortable runs.',
                'items' => ['Running Belt', 'Cooling Towel', 'Reflective Arm Bands'],
            ],
            [
                'name' => 'Tennis Match Box',
                'box_type' => 'tennis',
                'base_price' => 22,
                'base_image' => 'https://images.pexels.com/photos/5739118/pexels-photo-5739118.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Court-day gear for practice sessions and weekend matches.',
                'items' => ['Tennis Balls Pack', 'Tennis Grip Tape', 'Sweat Headband'],
            ],
            [
                'name' => 'Swim Training Box',
                'box_type' => 'swimming',
                'base_price' => 26,
                'base_image' => 'https://images.pexels.com/photos/863988/pexels-photo-863988.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Pool-ready training items for swimmers.',
                'items' => ['Swim Goggles', 'Swim Cap', 'Microfiber Towel'],
            ],
            [
                'name' => 'Boxing Conditioning Box',
                'box_type' => 'boxing',
                'base_price' => 27,
                'base_image' => 'https://images.pexels.com/photos/4761792/pexels-photo-4761792.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Conditioning and protection basics for boxing workouts.',
                'items' => ['Jump Rope', 'Hand Wraps', 'Mouth Guard'],
            ],
        ];

        foreach ($boxes as $boxData) {
            $itemNames = $boxData['items'];
            unset($boxData['items']);

            $box = Box::updateOrCreate(['name' => $boxData['name']], $boxData + ['is_active' => true]);

            foreach ($itemNames as $itemName) {
                $item = InventoryItem::where('name', $itemName)->first();
                BoxItem::updateOrCreate([
                    'box_id' => $box->id,
                    'inventory_item_id' => $item->id,
                ]);
            }
        }

        $theme = Themes::updateOrCreate(
            ['name' => 'May Performance Drop'],
            [
                'month' => 5,
                'description' => 'A rotating theme of performance gear and recovery items.',
                'image_url' => 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=800',
            ]
        );

        foreach (['Resistance Bands', 'Protein Bars', 'Shaker Bottle'] as $itemName) {
            $item = InventoryItem::where('name', $itemName)->first();
            ThemesItem::updateOrCreate([
                'theme_id' => $theme->id,
                'inventory_item_id' => $item->id,
            ]);
        }
    }
}
