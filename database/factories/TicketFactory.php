<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
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
        $ticketNumber = $this->faker->numberBetween(50, 1000);
        return [
            'event_id' => $this->faker->uuid(),
            'user_id' => $this->faker->uuid(),
            'order_id' => $this->faker->uuid(),
            'ticket_type_id' => $this->faker->uuid(),
            'name' => $this->faker->word,
            'description' => $this->faker->text(250),
            // 'price' => $this->faker->randomFloat(2, 1, 150),
            'status' => $this->faker->word,
            'total_quantity' => $ticketNumber,
            'available_quantity' => $ticketNumber,
            'start_date_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_date_time' => $this->faker->dateTimeBetween('+2 months', '+6 months'),
            // 'purchase_limit' => $this->faker->numberBetween(1, 5),
        ];
    }
}
