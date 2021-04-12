<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Storage;



class CustomerFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $json = Storage::disk('local')->get('cities.json');
        $cities = json_decode($json, true);

        $i = $this->faker->numberBetween(0, (count($cities)-1));
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->email,
            'region' => $cities[$i]['regione'],
            'province' => $cities[$i]['provincia'],
            'city' => $cities[$i]['comune'],
            'cap' => $cities[$i]['cap'],
            'address' => $this->faker->streetName . ', ' . $this->faker->numberBetween(1,200),
        ];
    }
}
