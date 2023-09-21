<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_list_tickets_for_an_event()
    {
        $event = Event::factory()->create();
        $tickets = Ticket::factory()->count(5)->create(['event_id' => $event->id]);

        $response = $this->getJson("/api/events/{$event->id}/tickets");

        $response->assertStatus(200);
        $this->assertCount(5, $response->json());
    }

    public function test_can_store_a_new_ticket_for_an_event()
    {
        $event = Event::factory()->create();
        $ticketData = [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 100),
        ];

        $response = $this->postJson("/api/events/{$event->id}/tickets", $ticketData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tickets', $ticketData);
    }

    public function test_can_show_a_specific_ticket_for_an_event()
    {
        $event = Event::factory()->create();
        $ticket = Ticket::factory()->create(['event_id' => $event->id]);

        $response = $this->getJson("/api/events/{$event->id}/tickets/{$ticket->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $ticket->id]);
    }

    public function test_can_update_a_ticket()
    {
        $event = Event::factory()->create();
        $ticket = Ticket::factory()->create(['event_id' => $event->id]);

        $ticketData = [
            'name' => 'Updated Name',
            'price' => 99.99,
        ];

        $response = $this->putJson("/api/events/{$event->id}/tickets/{$ticket->id}", $ticketData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tickets', $ticketData);
    }

    public function test_can_delete_a_ticket()
    {
        $event = Event::factory()->create();
        $ticket = Ticket::factory()->create(['event_id' => $event->id]);

        $response = $this->deleteJson("/api/events/{$event->id}/tickets/{$ticket->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }

    public function test_a_ticket_can_be_checked_in()
    {
        $ticket = Ticket::factory()->create(['status' => 'available']);

        $response = $this->patchJson("/api/tickets/{$ticket->id}/check-in");

        $response->assertStatus(200);
        $this->assertEquals('checked_in', $ticket->fresh()->status);
    }

    public function test_a_refunded_ticket_cannot_be_checked_in()
    {
        $ticket = Ticket::factory()->create(['status' => 'refunded']);

        $response = $this->patchJson("/api/tickets/{$ticket->id}/check-in");

        $response->assertStatus(400);
        $this->assertEquals('refunded', $ticket->fresh()->status);
    }

    public function test_an_already_checked_in_ticket_cannot_be_checked_in_again()
    {
        $ticket = Ticket::factory()->create(['status' => 'checked_in']);

        $response = $this->patchJson("/api/tickets/{$ticket->id}/check-in");

        $response->assertStatus(400);
        $this->assertEquals('checked_in', $ticket->fresh()->status);
    }
}
