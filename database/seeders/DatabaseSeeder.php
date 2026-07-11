<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'school_name' => 'Main Academy',
            'academic_year' => '2025/2026',
            'semester' => 'Semester 1',
        ]);

        // --- Admin ---
        User::create([
            'name' => 'Dr. Julian Reed',
            'email' => 'admin@eduflow.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // --- Classes ---
        $classNames = ['Grade 10A', 'Grade 10B', 'Grade 11A', 'Grade 11B', 'Grade 12A'];
        $classes = collect($classNames)->map(fn ($name, $i) => SchoolClass::create([
            'name' => $name,
            'room' => 'Room ' . (101 + $i),
            'capacity' => 30,
        ]));

        // --- Subjects (created before teachers are assigned) ---
        $subjectData = [
            ['name' => 'Mathematics', 'code' => 'MATH101'],
            ['name' => 'English', 'code' => 'ENG101'],
            ['name' => 'Programming', 'code' => 'PROG101'],
            ['name' => 'Networking', 'code' => 'NET101'],
            ['name' => 'Database Systems', 'code' => 'DB101'],
            ['name' => 'Physics', 'code' => 'PHY101'],
        ];

        // --- Teachers ---
        $teacherNames = ['Sarah Jenkins', 'Michael Chen', 'Amara Okafor', 'David Kim', 'Lena Novak', 'Omar Haddad'];
        $teachers = collect();
        foreach ($teacherNames as $i => $name) {
            $user = User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@eduflow.test',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'status' => 'active',
            ]);

            $teachers->push(Teacher::create([
                'user_id' => $user->id,
                'teacher_code' => 'TCH-' . str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                'department' => ['Science', 'Humanities', 'Computer Science', 'Computer Science', 'Mathematics', 'Science'][$i],
                'qualification' => 'M.Ed / M.Sc',
                'gender' => $i % 2 === 0 ? 'female' : 'male',
                'phone' => '+855 12 345 ' . (600 + $i),
            ]));
        }

        // Assign homeroom teachers to classes
        $classes->values()->each(function ($class, $i) use ($teachers) {
            $class->update(['teacher_id' => $teachers[$i % $teachers->count()]->id]);
        });

        // Create subjects, assigning a teacher + class round robin
        $subjects = collect();
        foreach ($subjectData as $i => $data) {
            $subjects->push(Subject::create([
                'name' => $data['name'],
                'code' => $data['code'],
                'teacher_id' => $teachers[$i % $teachers->count()]->id,
                'class_id' => $classes[$i % $classes->count()]->id,
            ]));
        }

        // --- Students ---
        $studentNames = [
            'Liam Carter', 'Emma Davis', 'Noah Patel', 'Olivia Tran', 'Ethan Brooks',
            'Ava Nguyen', 'Mason Lee', 'Sophia Rossi', 'Lucas Silva', 'Isabella Kim',
            'James Walker', 'Mia Chen', 'Benjamin Cole', 'Charlotte Reyes', 'Henry Diaz',
        ];

        $students = collect();
        foreach ($studentNames as $i => $name) {
            $user = User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@eduflow.test',
                'password' => Hash::make('password'),
                'role' => 'student',
                'status' => 'active',
            ]);

            $students->push(Student::create([
                'user_id' => $user->id,
                'student_code' => 'STU-' . str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                'class_id' => $classes[$i % $classes->count()]->id,
                'phone' => '+855 11 222 ' . (300 + $i),
                'gender' => $i % 2 === 0 ? 'male' : 'female',
                'dob' => now()->subYears(16)->subDays($i * 5),
                'guardian_name' => 'Guardian of ' . $name,
                'guardian_phone' => '+855 10 999 ' . (400 + $i),
                'address' => 'Phnom Penh, Cambodia',
            ]));
        }

        // Enroll students in the subjects belonging to their class, and generate grades + attendance
        foreach ($students as $student) {
            $classSubjects = $subjects->where('class_id', $student->class_id);

            foreach ($classSubjects as $subject) {
                $student->subjects()->attach($subject->id);

                $assignment = rand(60, 100);
                $quiz = rand(60, 100);
                $midterm = rand(55, 100);
                $final = rand(55, 100);
                $average = round(($assignment * 0.20) + ($quiz * 0.20) + ($midterm * 0.25) + ($final * 0.35), 2);

                Grade::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'assignment' => $assignment,
                    'quiz' => $quiz,
                    'midterm' => $midterm,
                    'final' => $final,
                    'average' => $average,
                    'grade' => Grade::letterGrade($average),
                    'approved' => (bool) rand(0, 1),
                ]);

                // Attendance for the last 10 school days
                for ($d = 10; $d >= 1; $d--) {
                    $date = now()->subDays($d);
                    if ($date->isWeekend()) continue;

                    $roll = rand(1, 100);
                    $status = $roll <= 85 ? 'present' : ($roll <= 92 ? 'late' : ($roll <= 97 ? 'absent' : 'excused'));

                    Attendance::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'teacher_id' => $subject->teacher_id,
                        'date' => $date->toDateString(),
                        'status' => $status,
                    ]);
                }
            }
        }

        // --- Announcements ---
        $admin = User::where('role', 'admin')->first();
        Announcement::create([
            'title' => 'Semester 2 Exam Schedule Published',
            'description' => 'The final examination timetable for Semester 2 has been published. Please check your class board for details.',
            'created_by' => $admin->id,
            'target_role' => 'all',
        ]);
        Announcement::create([
            'title' => 'Science Lab Equipment Restocked',
            'description' => 'New lab equipment has arrived for the Science department. Teachers may begin scheduling lab sessions.',
            'created_by' => $admin->id,
            'target_role' => 'teacher',
        ]);
        Announcement::create([
            'title' => 'Tomorrow Quiz — Please Bring a Calculator',
            'description' => 'A short quiz covering chapters 4-5 will be held tomorrow. Bring a calculator and your notebook.',
            'created_by' => $teachers->first()->user_id,
            'target_role' => 'student',
            'class_id' => $classes->first()->id,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin login: admin@eduflow.test / password');
        $this->command->info('Teacher login: sarah.jenkins@eduflow.test / password');
        $this->command->info('Student login: liam.carter@eduflow.test / password');
    }
}
