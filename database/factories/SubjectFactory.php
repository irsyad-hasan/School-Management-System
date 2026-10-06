<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'subject_name' => fake()->randomElement([
                'Mathematics',
                'English',
                'Indonesian Language',
                'Science',
                'Social Studies',
                'Computer Science',
                'Physical Education',
            ]),
            'subject_code' => fake()->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'jp' => fake()->numberBetween(2, 4),
            'archived' => false,
        ];
    }
}