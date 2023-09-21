<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User; // Assuming you have a User model for authentication
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_it_can_list_all_orders()
    {
        Order::factory()->count(5)->create();

        $response = $this->actingAs($this->user)->getJson('/api/orders');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data'); 
    }

    public function test_it_can_show_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->actingAs($this->user)->getJson('/api/orders/' . $order->id);

        $response->assertStatus(200)
                 ->assertJson(['id' => $order->id]);
    }

    public function test_it_can_refund_an_order()
    {
        $order = Order::factory()->create(['status' => 'paid']);
        $ticket = Ticket::factory()->create(['order_id' => $order->id, 'status' => 'sold']);

        $response = $this->actingAs($this->user)->putJson('/api/orders/' . $order->id . '/refund');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Order successfully refunded.']);

        $this->assertEquals('refunded', $order->fresh()->status);
        $this->assertEquals('refunded', $ticket->fresh()->status);
    }

    public function test_it_cannot_refund_a_checked_in_ticket()
    {
        $order = Order::factory()->create(['status' => 'paid']);
        Ticket::factory()->create(['order_id' => $order->id, 'status' => 'checked_in']);

        $response = $this->actingAs($this->user)->putJson('/api/orders/' . $order->id . '/refund');

        $response->assertStatus(400)
                 ->assertJson(['message' => 'Cannot refund an order with a checked-in ticket.']);
    }


}
