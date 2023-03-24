<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $minDate = '10.12.2018';
        $maxDate = '10.12.2019';
        $dateStartWork = $this->faker->dateTimeBetween($minDate,$maxDate);

        $faker = \Faker\Factory::create('uk_UA');

        return [
            'name'=>$this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'date_start_work' => $dateStartWork,
            'phone' => $faker->unique()->numerify('+380#########'),
            'salary' => $this->faker->randomFloat(2,10,1000)
        ];
    }
}
