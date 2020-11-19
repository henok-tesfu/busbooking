<?php

namespace Database\Factories;

use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Seat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arrayValues = ['booked', 'reserved', 'available'];
        return [
        'seatNumber' =>$this->faker->unique()->numberBetween($min = 1, $max = 65),
            'ticket_id'=> Ticket::factory()->create(),
            'status'=>'reserved',
            'travel_id'=>1,
            //'status'=>$arrayValues[rand(0,2)]

        ];
    }
}
