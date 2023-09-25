<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'order_id' => Order::factory(),
            'ticket_id' => Ticket::factory(),
            'atendee_name' => $this->faker->numberBetween(1, 10000),
        ];
    }
}
