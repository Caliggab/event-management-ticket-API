<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
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
        $ticketNumber = $this->faker->numberBetween(50, 1000);

        $ticketData = [
            'event_id' => $event->id,
            'user_id' => $this->faker->uuid(),
            'order_id' => $this->faker->uuid(),
            'ticket_type_id' => $this->faker->uuid(),
            'name' => $this->faker->word,
            'description' => $this->faker->text(250),
            // 'price' => $this->faker->randomFloat(2, 1, 150),
            'status' => $this->faker->word,
            'total_quantity' => $ticketNumber,
            'available_quantity' => $ticketNumber,
            'start_date_time' => $this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d H:i:s'),
            'end_date_time' => $this->faker->dateTimeBetween('+2 months', '+6 months')->format('Y-m-d H:i:s'),
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
            // 'price' => 99.99,
            'description' => 'Ticket desc',
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

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'deleted_at' => now(),
        ]);
    }

    public function test_a_ticket_can_be_checked_in()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ticket = Ticket::factory()->create(['status' => 'available']);

        $response = $this->patchJson("/api/{$ticket->id}/check-in");

        $response->assertStatus(200);
        $this->assertEquals('checked_in', $ticket->fresh()->status);
    }

    public function test_a_refunded_ticket_cannot_be_checked_in()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ticket = Ticket::factory()->create(['status' => 'refunded']);

        $response = $this->patchJson("/api/{$ticket->id}/check-in");

        $response->assertStatus(400);
        $this->assertEquals('refunded', $ticket->fresh()->status);
    }

    public function test_an_already_checked_in_ticket_cannot_be_checked_in_again()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $ticket = Ticket::factory()->create(['status' => 'checked_in']);

        $response = $this->patchJson("/api/{$ticket->id}/check-in");

        $response->assertStatus(400);
        $this->assertEquals('checked_in', $ticket->fresh()->status);
    }
}
