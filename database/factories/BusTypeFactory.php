<?php

namespace Database\Factories;

use App\Models\BusType;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BusType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => "BTYPE ".$this->faker->name,
        ];
    }
}
