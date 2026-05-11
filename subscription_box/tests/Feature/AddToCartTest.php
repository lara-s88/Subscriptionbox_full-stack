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

class AddToCartTest extends TestCase
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

    private function makePlan($boxesPerMonth = 2)
    {
        return Plan::create([
            'name'            => 'Basic',
            'price_monthly'   => 29.99,
            'boxes_per_month' => $boxesPerMonth,
            'swap_limit'      => 1,
        ]);
    }

    private function makeBox()
    {
        return Box::create([
            'name'       => 'Sports Box',
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

    private function validCartInput()
    {
        return [
            'clothing_size'      => 'M',
            'diet_preference'    => 'standard',
            'delivery_frequency' => 'Monthly',
        ];
    }

    // ── tests ─────────────────────────────────────────────────────────

    #[Test]
    public function it_rejects_adding_box_with_no_plan()
    {
        $user = $this->makeUser();
        $box  = $this->makeBox();

        $response = $this->actingAs($user)
            ->post("/boxes/{$box->id}/add-to-cart", $this->validCartInput());

        $response->assertRedirect(route('subscriptions'));
        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_rejects_adding_box_when_subscription_is_paused()
    {
        $user = $this->makeUser();
        $plan = $this->makePlan();
        $box  = $this->makeBox();
        $this->makeSubscription($user, $plan, 'paused');

        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);

        $response = $this->actingAs($user)
            ->post("/boxes/{$box->id}/add-to-cart", $this->validCartInput());

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_rejects_invalid_clothing_size()
    {
        $user = $this->makeUser();
        $plan = $this->makePlan();
        $box  = $this->makeBox();
        $this->makeSubscription($user, $plan);

        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);

        $response = $this->actingAs($user)
            ->post("/boxes/{$box->id}/add-to-cart", [
                'clothing_size'      => 'XXXL',   // invalid
                'diet_preference'    => 'standard',
                'delivery_frequency' => 'Monthly',
            ]);

        $response->assertSessionHasErrors('clothing_size');
    }

    #[Test]
    public function it_rejects_invalid_diet_preference()
    {
        $user = $this->makeUser();
        $plan = $this->makePlan();
        $box  = $this->makeBox();
        $this->makeSubscription($user, $plan);

        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);

        $response = $this->actingAs($user)
            ->post("/boxes/{$box->id}/add-to-cart", [
                'clothing_size'      => 'M',
                'diet_preference'    => 'carnivore',  // invalid
                'delivery_frequency' => 'Monthly',
            ]);

        $response->assertSessionHasErrors('diet_preference');
    }

    #[Test]
    public function it_rejects_when_monthly_limit_reached()
    {
        $user = $this->makeUser();
        $plan = $this->makePlan(1);  // only 1 box per month
        $box  = $this->makeBox();
        $this->makeSubscription($user, $plan);

        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);

        // already has 1 order this month = at the limit
        BoxOrder::create([
            'user_id'      => $user->id,
            'box_id'       => $box->id,
            'order_number' => 'BOX-EXISTING01',
            'status'       => 'pending',
            'total_amount' => 49.99,
        ]);

        $box2 = Box::create([
            'name'       => 'Yoga Box',
            'box_type'   => 'yoga',
            'base_price' => 39.99,
            'is_active'  => true,
        ]);

        $response = $this->actingAs($user)
            ->post("/boxes/{$box2->id}/add-to-cart", $this->validCartInput());

        $response->assertRedirect(route('boxes'));
        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_rejects_same_box_already_in_cart()
    {
        $user = $this->makeUser();
        $plan = $this->makePlan(5);
        $box  = $this->makeBox();
        $this->makeSubscription($user, $plan);

        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);

        // same box already pending
        BoxOrder::create([
            'user_id'      => $user->id,
            'box_id'       => $box->id,
            'order_number' => 'BOX-EXISTING01',
            'status'       => 'pending',
            'total_amount' => 49.99,
        ]);

        $response = $this->actingAs($user)
            ->post("/boxes/{$box->id}/add-to-cart", $this->validCartInput());

        $response->assertRedirect(route('cart'));
        $response->assertSessionHas('error');
    }

    #[Test]
    public function it_adds_box_to_cart_successfully()
    {
        $user = $this->makeUser();
        $plan = $this->makePlan(5);
        $box  = $this->makeBox();
        $this->makeSubscription($user, $plan);

        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);

        $response = $this->actingAs($user)
            ->post("/boxes/{$box->id}/add-to-cart", $this->validCartInput());

        $response->assertRedirect(route('cart'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('box_orders', [
            'user_id' => $user->id,
            'box_id'  => $box->id,
            'status'  => 'pending',
        ]);
    }

    #[Test]
    public function it_rejects_invalid_delivery_frequency()
    {
        $user = $this->makeUser();
        $plan = $this->makePlan();
        $box  = $this->makeBox();
        $this->makeSubscription($user, $plan);

        Customer::create(['user_id' => $user->id, 'plan_id' => $plan->id]);

        $response = $this->actingAs($user)
            ->post("/boxes/{$box->id}/add-to-cart", [
                'clothing_size'      => 'M',
                'diet_preference'    => 'standard',
                'delivery_frequency' => 'Weekly',  // invalid
            ]);

        $response->assertSessionHasErrors('delivery_frequency');
    }
}
