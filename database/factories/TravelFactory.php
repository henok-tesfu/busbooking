<?php

namespace Database\Factories;

use App\Models\BusType;
use App\Models\City;
use App\Models\Company;
use App\Models\Travel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Travel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = Company::all();
        return [
            'startCityId'=>1,
            'dropOfCityId'=>2,
            'travel_km'=>100,
            'travel_pickup_time' => '03:30:PM',
            'travel_minutes'=>4000,
            'busType_id'=>BusType::factory()->create(),
            'company_id'=>1,//$this->faker->unique()->randomElement($company->pluck('id')),
            'side_number'=>'BU'.$this->faker->numberBetween(100,1000),
            'price'=>200,
            'Gregorian'=>date('y/m/d'),
            'local'=>date('y/m/d'),
        ];
    }
}
