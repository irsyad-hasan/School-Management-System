<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SchoolDataSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Subjects
        |--------------------------------------------------------------------------
        */

        $subjectsData = [
            [
                'subject_name' => 'Mathematics',
                'subject_code' => 'MAT101',
                'credits' => 4,
            ],
            [
                'subject_name' => 'English',
                'subject_code' => 'ENG101',
                'credits' => 3,
            ],
            [
                'subject_name' => 'Science',
                'subject_code' => 'SCI101',
                'credits' => 4,
            ],
            [
                'subject_name' => 'Computer Science',
                'subject_code' => 'CSC101',
                'credits' => 3,
            ],
            [
                'subject_name' => 'Indonesian Language',
                'subject_code' => 'IND101',
                'credits' => 3,
            ],
        ];

        $subjects = collect();

        foreach ($subjectsData as $subjectData) {
            $subject = Subject::updateOrCreate(
                [
                    'subject_code' => $subjectData['subject_code'],
                ],
                [
                    'subject_name' => $subjectData['subject_name'],
                    'credits' => $subjectData['credits'],
                    'archived' => false,
                ]
            );

            $subject->slug = Str::slug(
                $subject->subject_name . '-' . $subject->subject_id
            );

            $subject->save();

            $subjects->push($subject);
        }

        /*
        |--------------------------------------------------------------------------
        | Teachers
        |--------------------------------------------------------------------------
        */

        $teachersData = [
            [
                'username' => 'teacher.math',
                'email' => 'teacher.math@email.com',
                'full_name' => 'Andi Pratama',
                'nip' => '198501012010011001',
            ],
            [
                'username' => 'teacher.english',
                'email' => 'teacher.english@email.com',
                'full_name' => 'Budi Santoso',
                'nip' => '198602022011021002',
            ],
            [
                'username' => 'teacher.science',
                'email' => 'teacher.science@email.com',
                'full_name' => 'Citra Lestari',
                'nip' => '198703032012031003',
            ],
            [
                'username' => 'teacher.computer',
                'email' => 'teacher.computer@email.com',
                'full_name' => 'Dedi Kurniawan',
                'nip' => '198804042013041004',
            ],
            [
                'username' => 'teacher.indonesia',
                'email' => 'teacher.indonesia@email.com',
                'full_name' => 'Eka Wulandari',
                'nip' => '198905052014051005',
            ],
        ];

        $teachers = collect();

        foreach ($teachersData as $index => $teacherData) {
            $user = User::updateOrCreate(
                [
                    'email' => $teacherData['email'],
                ],
                [
                    'username' => $teacherData['username'],
                    'password' => Hash::make('password'),
                    'role' => 'teacher',
                    'archived' => false,
                ]
            );

            $teacher = Teacher::updateOrCreate(
                [
                    'nip' => $teacherData['nip'],
                ],
                [
                    'user_id' => $user->user_id,
                    'full_name' => $teacherData['full_name'],
                    'subject_id' => $subjects[$index]->subject_id,
                    'archived' => false,
                ]
            );

            $teacher->slug = Str::slug(
                $teacher->full_name . '-' . $teacher->teacher_id
            );

            $teacher->save();

            $teachers->push($teacher);
        }

        /*
        |--------------------------------------------------------------------------
        | Classes
        |--------------------------------------------------------------------------
        */

        $classesData = [
            [
                'class_name' => 'Grade 10 A',
                'homeroom_teacher_id' => $teachers[0]->teacher_id,
                'academic_year' => '2026/2027',
            ],
            [
                'class_name' => 'Grade 10 B',
                'homeroom_teacher_id' => $teachers[1]->teacher_id,
                'academic_year' => '2026/2027',
            ],
            [
                'class_name' => 'Grade 11 A',
                'homeroom_teacher_id' => $teachers[2]->teacher_id,
                'academic_year' => '2026/2027',
            ],
        ];

        $classes = collect();

        foreach ($classesData as $classData) {
            $schoolClass = SchoolClass::updateOrCreate(
                [
                    'class_name' => $classData['class_name'],
                    'academic_year' => $classData['academic_year'],
                ],
                [
                    'homeroom_teacher_id' => $classData['homeroom_teacher_id'],
                    'archived' => false,
                ]
            );

            $schoolClass->slug = Str::slug(
                $schoolClass->class_name . '-' . $schoolClass->class_id
            );

            $schoolClass->save();

            $classes->push($schoolClass);
        }

        /*
        |--------------------------------------------------------------------------
        | Students
        |--------------------------------------------------------------------------
        */

        $studentsData = [
            [
                'username' => 'student.001',
                'email' => 'student001@email.com',
                'full_name' => 'Ahmad Fauzan',
                'nis' => '2026000001',
                'class_index' => 0,
                'date_of_birth' => '2009-01-15',
            ],
            [
                'username' => 'student.002',
                'email' => 'student002@email.com',
                'full_name' => 'Bella Putri',
                'nis' => '2026000002',
                'class_index' => 0,
                'date_of_birth' => '2009-02-20',
            ],
            [
                'username' => 'student.003',
                'email' => 'student003@email.com',
                'full_name' => 'Cahyo Ramadhan',
                'nis' => '2026000003',
                'class_index' => 0,
                'date_of_birth' => '2009-03-10',
            ],
            [
                'username' => 'student.004',
                'email' => 'student004@email.com',
                'full_name' => 'Dinda Maharani',
                'nis' => '2026000004',
                'class_index' => 0,
                'date_of_birth' => '2009-04-05',
            ],
            [
                'username' => 'student.005',
                'email' => 'student005@email.com',
                'full_name' => 'Eko Saputra',
                'nis' => '2026000005',
                'class_index' => 0,
                'date_of_birth' => '2009-05-18',
            ],

            [
                'username' => 'student.006',
                'email' => 'student006@email.com',
                'full_name' => 'Fajar Nugroho',
                'nis' => '2026000006',
                'class_index' => 1,
                'date_of_birth' => '2009-06-22',
            ],
            [
                'username' => 'student.007',
                'email' => 'student007@email.com',
                'full_name' => 'Gita Permata',
                'nis' => '2026000007',
                'class_index' => 1,
                'date_of_birth' => '2009-07-12',
            ],
            [
                'username' => 'student.008',
                'email' => 'student008@email.com',
                'full_name' => 'Hendra Wijaya',
                'nis' => '2026000008',
                'class_index' => 1,
                'date_of_birth' => '2009-08-25',
            ],
            [
                'username' => 'student.009',
                'email' => 'student009@email.com',
                'full_name' => 'Intan Sari',
                'nis' => '2026000009',
                'class_index' => 1,
                'date_of_birth' => '2009-09-14',
            ],
            [
                'username' => 'student.010',
                'email' => 'student010@email.com',
                'full_name' => 'Joko Susanto',
                'nis' => '2026000010',
                'class_index' => 1,
                'date_of_birth' => '2009-10-08',
            ],

            [
                'username' => 'student.011',
                'email' => 'student011@email.com',
                'full_name' => 'Kania Putri',
                'nis' => '2026000011',
                'class_index' => 2,
                'date_of_birth' => '2008-11-17',
            ],
            [
                'username' => 'student.012',
                'email' => 'student012@email.com',
                'full_name' => 'Lukman Hakim',
                'nis' => '2026000012',
                'class_index' => 2,
                'date_of_birth' => '2008-12-03',
            ],
            [
                'username' => 'student.013',
                'email' => 'student013@email.com',
                'full_name' => 'Maya Anggraini',
                'nis' => '2026000013',
                'class_index' => 2,
                'date_of_birth' => '2009-01-28',
            ],
            [
                'username' => 'student.014',
                'email' => 'student014@email.com',
                'full_name' => 'Nanda Prakoso',
                'nis' => '2026000014',
                'class_index' => 2,
                'date_of_birth' => '2009-02-16',
            ],
            [
                'username' => 'student.015',
                'email' => 'student015@email.com',
                'full_name' => 'Olivia Safitri',
                'nis' => '2026000015',
                'class_index' => 2,
                'date_of_birth' => '2009-03-21',
            ],
        ];

        foreach ($studentsData as $studentData) {
            $user = User::updateOrCreate(
                [
                    'email' => $studentData['email'],
                ],
                [
                    'username' => $studentData['username'],
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'archived' => false,
                ]
            );

            $student = Student::updateOrCreate(
                [
                    'nis' => $studentData['nis'],
                ],
                [
                    'user_id' => $user->user_id,
                    'full_name' => $studentData['full_name'],
                    'class_id' => $classes[$studentData['class_index']]->class_id,
                    'date_of_birth' => $studentData['date_of_birth'],
                    'archived' => false,
                ]
            );

            $student->slug = Str::slug(
                $student->full_name . '-' . $student->student_id
            );

            $student->save();
        }
    }
}