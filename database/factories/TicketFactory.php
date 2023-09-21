<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 1, 150),
            'quantity_available' => $this->faker->numberBetween(50, 1000),
            'sale_start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'sale_end_date' => $this->faker->dateTimeBetween('+2 months', '+6 months'),
            'purchase_limit' => $this->faker->numberBetween(1, 5),
        ];
    }
}
