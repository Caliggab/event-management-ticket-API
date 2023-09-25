<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTypeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $event = Event::factory()->create();
    }

    public function test_a_user_can_create_a_ticket_type()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create(['user_id' => $user->id]);
        $ticketTypeData = [
            'name' => 'Regular',
            'description' => $this->faker->text(200),
            'total_quantity' => $this->faker->numberBetween(1, 200),
            'available_quantity' => $this->faker->numberBetween(1, 200),
            'event_id' => $event->id,
            'price' => 50,
            'sale_start_date' => now(),
            'sale_end_date' => now()->addDays(10),
        ];

        $response = $this->post(route('events.ticket-types.store', ['event' => $event->id]), $ticketTypeData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_types', ['name' => 'Regular']);
    }

    public function test_a_user_can_view_a_ticket_type()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

        $response = $this->get(route('events.ticket-types.show', ['event' => $event->id, 'ticket_type' => $ticketType->id]));

        $response->assertStatus(200);
        $response->assertJson(['data' => ['name' => $ticketType->name]]);
    }

    public function test_a_user_can_update_a_ticket_type()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);
        $updateData = ['name' => 'VIP'];

        $response = $this->put(route('events.ticket-types.update', ['event' => $event->id, 'ticket_type' => $ticketType->id]), $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_types', ['id' => $ticketType->id, 'name' => 'VIP']);
    }

    public function test_a_user_can_delete_a_ticket_type()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

        $response = $this->delete(route('events.ticket-types.destroy', ['event' => $event->id, 'ticket_type' => $ticketType->id]));

        $response->assertStatus(204);
        $this->assertSoftDeleted('ticket_types', ['id' => $ticketType->id]);
    }
}
