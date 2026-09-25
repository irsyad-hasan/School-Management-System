<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->teacher(),
            'full_name' => fake()->name(),
            'nip' => fake()->unique()->numerify('##################'),
            'subject_id' => Subject::factory(),
            'archived' => false,
        ];
    }
}