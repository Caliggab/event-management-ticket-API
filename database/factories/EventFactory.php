<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'description' => $this->faker->text(250),
            'start_date_time' => $this->faker->dateTimeBetween('now', '+1 year'),
            'end_date_time' => $this->faker->dateTimeBetween('+2 year', '+3 years'),
            'location' => $this->faker->address,
            'header_image' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(['published', 'drafted']),
        ];
    }
}
