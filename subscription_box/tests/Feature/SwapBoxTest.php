<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Box;
use App\Models\BoxOrder;
use App\Models\Plan;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class SwapBoxTest extends TestCase
{
    use RefreshDatabase;

    // ── helpers ──────────────────────────────────────────────────────

    private function makeUser()
    {
        return User::create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'user@test.com',
            'password'   => Hash::make('password123'),
        ]);
    }

    private function makePlan()
    {
        return Plan::create([
            'name'            => 'Basic',
            'price_monthly'   => 29.99,
            'boxes_per_month' => 2,
            'swap_limit'      => 3,
        ]);
    }

    private function makeBox($name = 'Sports Box')
    {
        return Box::create([
            'name'       => $name,
            'box_type'   => 'fitness',
            'base_price' => 49.99,
            'is_active'  => true,
        ]);
    }

    private function makeSubscription(User $user, Plan $plan, $status = 'active')
    {
        return Subscription::create([
            'user_id'           => $user->id,
            'plan_id'           => $plan->id,
            'status'            => $status,
            'last_billing_date' => now()->toDateString(),
            'next_billing_date' => now()->addMonth()->toDateString(),
            'started_at'        => now()->toDateString(),
            'pause_until'       => now()->toDateString(),
            'renewal_day'       => now()->day,
        ]);
    }

    private function makeOrder(User $user, Box $box, $status = 'pending')
    {
        return BoxOrder::create([
            'user_id'      => $user->id,
            'box_id'       => $box->id,
            'order_number' => 'BOX-' . strtoupper(uniqid()),
            'status'       => $status,
            'total_amount' => $box->base_price,
        ]);
    }

    // ── tests ─────────────────────────────────────────────────────────

    #[Test]
    public function it_rejects_swap_when_subscription_is_paused()
    {
        $user  = $this->makeUser();
        $plan  = $this->makePlan();
        $box   = $this->makeBox('Old Box');
        $box2  = $this->makeBox('New Box');

        $this->makeSubscription($user, $plan, 'paused');
        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);
        $order = $this->makeOrder($user, $box);

        $response = $this->actingAs($user)
            ->post("/orders/{$order->id}/swap", [
                'box_id' => $box2->id,
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_rejects_missing_box_id()
    {
        $user  = $this->makeUser();
        $plan  = $this->makePlan();
        $box   = $this->makeBox();

        $this->makeSubscription($user, $plan);
        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);
        $order = $this->makeOrder($user, $box);

        $response = $this->actingAs($user)
            ->post("/orders/{$order->id}/swap", [
                'box_id' => '',   // missing
            ]);

        $response->assertSessionHasErrors('box_id');
    }

    #[Test]
    public function it_rejects_non_existent_box_id()
    {
        $user  = $this->makeUser();
        $plan  = $this->makePlan();
        $box   = $this->makeBox();

        $this->makeSubscription($user, $plan);
        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);
        $order = $this->makeOrder($user, $box);

        $response = $this->actingAs($user)
            ->post("/orders/{$order->id}/swap", [
                'box_id' => 9999,   // does not exist
            ]);

        $response->assertSessionHasErrors('box_id');
    }

    #[Test]
    public function it_rejects_swapping_with_the_same_box()
    {
        $user  = $this->makeUser();
        $plan  = $this->makePlan();
        $box   = $this->makeBox();

        $this->makeSubscription($user, $plan);
        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);
        $order = $this->makeOrder($user, $box);

        $response = $this->actingAs($user)
            ->post("/orders/{$order->id}/swap", [
                'box_id' => $box->id,   // same box
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_rejects_swap_if_user_already_has_target_box()
    {
        $user  = $this->makeUser();
        $plan  = $this->makePlan();
        $box1  = $this->makeBox('Box One');
        $box2  = $this->makeBox('Box Two');

        $this->makeSubscription($user, $plan);
        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);

        $order = $this->makeOrder($user, $box1);

        // user already has box2 in another active order
        $this->makeOrder($user, $box2, 'packed');

        $response = $this->actingAs($user)
            ->post("/orders/{$order->id}/swap", [
                'box_id' => $box2->id,
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_rejects_swap_on_delivered_order()
    {
        $user  = $this->makeUser();
        $plan  = $this->makePlan();
        $box1  = $this->makeBox('Box One');
        $box2  = $this->makeBox('Box Two');

        $this->makeSubscription($user, $plan);
        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);

        // delivered order is outside the active statuses
        $order = $this->makeOrder($user, $box1, 'delivered');

        $response = $this->actingAs($user)
            ->post("/orders/{$order->id}/swap", [
                'box_id' => $box2->id,
            ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function it_swaps_box_successfully()
    {
        $user  = $this->makeUser();
        $plan  = $this->makePlan();
        $box1  = $this->makeBox('Old Box');
        $box2  = $this->makeBox('New Box');

        $this->makeSubscription($user, $plan);
        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);
        $order = $this->makeOrder($user, $box1);

        $response = $this->actingAs($user)
            ->post("/orders/{$order->id}/swap", [
                'box_id' => $box2->id,
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('box_orders', [
            'id'     => $order->id,
            'box_id' => $box2->id,
        ]);
    }
}