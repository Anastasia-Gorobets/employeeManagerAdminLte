<?php

namespace Database\Factories;

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
        return [
            'name'=>$this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'date_start_work' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'phone' => $this->faker->phoneNumber(),
            'salary' => $this->faker->randomFloat(2,10,1000)
        ];
    }
}
