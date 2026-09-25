<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->student(),
            'full_name' => fake()->name(),
            'nis' => fake()->unique()->numerify('##########'),
            'class_id' => SchoolClass::factory(),
            'date_of_birth' => fake()->dateTimeBetween('-20 years', '-15 years')
                ->format('Y-m-d'),
            'archived' => false,
        ];
    }
}