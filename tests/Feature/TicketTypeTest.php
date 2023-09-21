<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTypeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $event = Event::factory()->create();
    }

    public function test_a_user_can_create_a_ticket_type()
    {

        $event = Event::factory()->create();
        $ticketTypeData = [
            'event_id' => $event->id,
            'name' => 'Regular',
            'price' => 50,
            'sale_start_date' => now(),
            'sale_end_date' => now()->addDays(10)
        ];

        $response = $this->post(route('ticket-types.store'), $ticketTypeData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('ticket_types', ['name' => 'Regular']);
    }

    public function test_a_user_can_view_a_ticket_type()
    {
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

        $response = $this->get(route('ticket-types.show', $ticketType));

        $response->assertStatus(200);
        $response->assertJson(['name' => $ticketType->name]);
    }

    public function test_a_user_can_update_a_ticket_type()
    {
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);
        $updateData = ['name' => 'VIP'];

        $response = $this->put(route('ticket-types.update', $ticketType), $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ticket_types', ['id' => $ticketType->id, 'name' => 'VIP']);
    }

    public function test_a_user_can_delete_a_ticket_type()
    {
        $event = Event::factory()->create();
        $ticketType = TicketType::factory()->create(['event_id' => $event->id]);

        $response = $this->delete(route('ticket-types.destroy', $ticketType));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('ticket_types', ['id' => $ticketType->id]);
    }

}

