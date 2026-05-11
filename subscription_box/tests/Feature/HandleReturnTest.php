<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Box;
use App\Models\User;
use App\Models\Returns;
use App\Models\BoxOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class HandleReturnTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin()
    {
        return \App\Models\Admin::create([
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'email'      => 'admin@test.com',
            'password'   => Hash::make('password123'),
        ]);
    }

    private function makeOrder(): BoxOrder
    {
        $user = User::create([
            'first_name' => 'Return',
            'last_name'  => 'User',
            'email'      => 'return-user@test.com',
            'password'   => Hash::make('password123'),
        ]);

        $box = Box::create([
            'name'       => 'Return Box',
            'box_type'   => 'fitness',
            'base_price' => 49.99,
            'is_active'  => true,
        ]);

        return BoxOrder::create([
            'user_id'      => $user->id,
            'box_id'       => $box->id,
            'order_number' => 'BOX-' . strtoupper(uniqid()),
            'status'       => 'delivered',
            'total_amount' => $box->base_price,
        ]);
    }

    #[Test]
    public function it_rejects_already_processed_return()
    {
        $admin  = $this->makeAdmin();
        $order = $this->makeOrder();
        $return = Returns::create([
            'order_id' => $order->id,
            'status'   => 'approved',
            'image'    => 'proof.jpg',
            'reason'   => 'damaged',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->post("/admin/returns/{$return->id}", ['action' => 'approved']);

        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_rejects_return_with_no_image()
    {
        $admin  = $this->makeAdmin();
        $order = $this->makeOrder();
        $return = Returns::create([
            'order_id' => $order->id,
            'status'   => 'pending',
            'image'    => null,
            'reason'   => 'damaged',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->post("/admin/returns/{$return->id}", ['action' => 'approved']);

        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_rejects_invalid_action()
    {
        $admin  = $this->makeAdmin();
        $order = $this->makeOrder();
        $return = Returns::create([
            'order_id' => $order->id,
            'status'   => 'pending',
            'image'    => 'proof.jpg',
            'reason'   => 'damaged',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->post("/admin/returns/{$return->id}", ['action' => 'refund']);

        $response->assertSessionHasErrors('action');
    }

    #[Test]
    public function it_approves_a_valid_return()
    {
        $admin  = $this->makeAdmin();
        $order = $this->makeOrder();
        $return = Returns::create([
            'order_id' => $order->id,
            'status'   => 'pending',
            'image'    => 'proof.jpg',
            'reason'   => 'damaged',
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->post("/admin/returns/{$return->id}", ['action' => 'approved']);

        $this->assertDatabaseHas('returns', [
            'id'     => $return->id,
            'status' => 'approved',
        ]);
    }
}
