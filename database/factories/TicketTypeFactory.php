<?php

namespace Database\Factories;

use App\Models\TicketType;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TicketType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $total_quantity = $this->faker->numberBetween(50, 500);

        return [
            'name' => $this->faker->words(2, true) . ' Ticket',
            'description' => $this->faker->sentence(5),
            'event_id' => Event::factory(),
            'price' => $this->faker->numberBetween(10, 500),
            'total_quantity' => $total_quantity,
            'available_quantity' => $this->faker->numberBetween(0, $total_quantity), // Available tickets should be less than or equal to the total quantity
        ];
    }
}
