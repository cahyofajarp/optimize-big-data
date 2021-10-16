<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'company_origin' => $this->faker->sentence(10),
            'position_title' => 'Manager',
            'last_education' => 'S1',
            'born_date' => $this->faker->date('Y-m-d'),
        ];
    }
}
