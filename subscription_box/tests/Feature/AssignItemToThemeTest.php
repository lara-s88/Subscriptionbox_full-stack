<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Themes;
use App\Models\InventoryItem;
use App\Models\ThemesItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class AssignItemToThemeTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin()
    {
        return Admin::create([
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'email'      => 'admin@test.com',
            'password'   => Hash::make('password123'),
        ]);
    }

    #[Test]
    public function it_rejects_invalid_theme_id()
    {
        $admin = $this->makeAdmin();
        $item  = InventoryItem::create([
            'name' => 'Ball', 'category' => 'sport',
            'unit_price' => 10, 'stock_qty' => 5,
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->post('/admin/themes/assign', [
                'theme_id'          => 9999,
                'inventory_item_id' => $item->id,
            ]);

        $response->assertSessionHasErrors('theme_id');
    }

    #[Test]
    public function it_rejects_duplicate_assignment()
    {
        $admin = $this->makeAdmin();
        $theme = Themes::create([
            'name' => 'Summer', 'month' => 6,
        ]);
        $item = InventoryItem::create([
            'name' => 'Ball', 'category' => 'sport',
            'unit_price' => 10, 'stock_qty' => 5,
        ]);

        ThemesItem::create([
            'theme_id'          => $theme->id,
            'inventory_item_id' => $item->id,
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->post('/admin/themes/assign', [
                'theme_id'          => $theme->id,
                'inventory_item_id' => $item->id,
            ]);

        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_assigns_item_to_theme_successfully()
    {
        $admin = $this->makeAdmin();
        $theme = Themes::create(['name' => 'Summer', 'month' => 6]);
        $item  = InventoryItem::create([
            'name' => 'Ball', 'category' => 'sport',
            'unit_price' => 10, 'stock_qty' => 5,
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->post('/admin/themes/assign', [
                'theme_id'          => $theme->id,
                'inventory_item_id' => $item->id,
            ]);

        $this->assertDatabaseHas('themes_items', [
            'theme_id'          => $theme->id,
            'inventory_item_id' => $item->id,
        ]);
    }
}
