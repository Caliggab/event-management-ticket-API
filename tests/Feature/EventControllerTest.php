<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_authorized_user_can_create_event()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create(['user_id' => $user->id]);

        $start = $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days')->format('Y-m-d H:i:s');
        $end = $this->faker->dateTimeBetween($start, $start . ' +2 days')->format('Y-m-d H:i:s');

        $eventData = [
            'name' => $this->faker->name,
            'description' => $this->faker->text(250),
            'start_date_time' => $start,
            'end_date_time' => $end,
            'location' => $this->faker->address,
            'header_image' => $this->faker->imageUrl(),
            'status' => 'drafted',
        ];

        // $ticketTypeA = TicketType::factory()->create(['name' => 'Early Bird', 'event_id'=> $event->id]);
        // $ticketTypeB = TicketType::factory()->create(['name' => 'VIP', 'event_id'=> $event->id]);


        // Ticket::factory()->create(['available_quantity' => 50, 'ticket_type_id' => $ticketTypeA->id, 'event_id'=> $event->id]);
        // Ticket::factory()->create(['available_quantity' => 20, 'ticket_type_id' => $ticketTypeB->id, 'event_id'=> $event->id]);
        

        $response = $this->postJson(route('events.store'), $eventData);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => $eventData['name']]);
    }

    public function test_unauthorized_user_cannot_create_event()
    {

        $start = $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days')->format('Y-m-d H:i:s');
        $end = $this->faker->dateTimeBetween($start, $start . ' +2 days')->format('Y-m-d H:i:s');

        $eventData = [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'start_date_time' => $start,
            'end_date_time' => $end,
            'location' => $this->faker->address,
            'header_image' => $this->faker->imageUrl(),
            'status' => 'drafted',
        ];

        $response = $this->postJson(route('events.store'), $eventData);

        $response->assertStatus(401);
    }

    public function test_unauthorized_users_can_view_all_events()
    {
        Event::factory()->count(3)->create();

        $response = $this->get('/api/events');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_can_update_event_name()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $updatedEventData = ['name' => 'Updated Event Name'];

        $response = $this->patchJson(route('events.update', $event->id), $updatedEventData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Event Name']);
    }

    public function test_can_update_event_end_date()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $newDate = now()->addDay()->format('Y-m-d H:i:s');

        $updatedEventData = ['end_date_time' => $newDate];

        $response = $this->patchJson(route('events.update', $event->id), $updatedEventData);

        $response->assertStatus(200)
            ->assertJsonFragment(['end_date_time' => $newDate]);
    }

    public function test_can_show_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->getJson(route('events.show', $event->id));

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $event->name]);
    }

    public function test_can_delete_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->deleteJson(route('events.destroy', $event->id));

        $response->assertStatus(204);
        $this->assertSoftDeleted($event);
    }
}
