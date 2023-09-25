<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Event;
use App\Models\OrderDetail;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->uuid(),
            'event_id' => $this->faker->uuid(),
            // 'ticket_id' => $this->faker->uuid(),
            'atendee_name' => $this->faker->name(),


            // 'order_detail_id' => OrderDetail::factory(),
            'total_price' => $this->faker->numberBetween(1, 10000),
            'status' => 'pending',
            'purchase_date' => $this->faker->dateTimeThisYear,
        ];
    }
}
