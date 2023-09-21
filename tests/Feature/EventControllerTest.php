<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_event()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $start = $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $end = $this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +2 days');



        $eventData = [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'start_date_time' => '2023-09-21 06:20:37',
            'end_date_time' => '2023-11-21 06:20:37',
            'location' => $this->faker->address,
            'header_image' => $this->faker->imageUrl(),
            'status' => 'drafted',
        ];

        $response = $this->postJson(route('events.store'), $eventData);

        // info(print_r($response, true));

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => $eventData['name']]);
    }

    public function test_can_update_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $updatedEventData = ['name' => 'Updated Event Name'];

        $response = $this->patchJson(route('events.update', $event->id), $updatedEventData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Event Name']);
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
