<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Travel;
use App\Models\User;
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
            //'number_of_seats'=>1,
            'travel_id' => 1,
            'user_id'=>User::factory()->create()
        ];
    }
}
