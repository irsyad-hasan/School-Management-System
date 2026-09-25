<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SchoolClass>
 */
class SchoolClassFactory extends Factory
{
    protected $model = SchoolClass::class;

    public function definition(): array
    {
        return [
            'class_name' => fake()->randomElement([
                'Grade 10 A',
                'Grade 10 B',
                'Grade 11 A',
                'Grade 11 B',
                'Grade 12 A',
                'Grade 12 B',
            ]),
            'homeroom_teacher_id' => Teacher::factory(),
            'academic_year' => '2026/2027',
            'archived' => false,
        ];
    }
}