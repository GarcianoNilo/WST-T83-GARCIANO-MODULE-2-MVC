<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // Computer Science subjects
            ['code' => 'CS101', 'name' => 'Introduction to Programming', 'units' => 3, 'course' => 'BSCS', 'year_level' => '1st Year'],
            ['code' => 'CS102', 'name' => 'Data Structures and Algorithms', 'units' => 3, 'course' => 'BSCS', 'year_level' => '1st Year'],
            ['code' => 'CS201', 'name' => 'Object-Oriented Programming', 'units' => 3, 'course' => 'BSCS', 'year_level' => '2nd Year'],
            ['code' => 'CS202', 'name' => 'Database Management Systems', 'units' => 3, 'course' => 'BSCS', 'year_level' => '2nd Year'],
            ['code' => 'CS301', 'name' => 'Software Engineering', 'units' => 3, 'course' => 'BSCS', 'year_level' => '3rd Year'],
            ['code' => 'CS302', 'name' => 'Web Development', 'units' => 3, 'course' => 'BSCS', 'year_level' => '3rd Year'],
            ['code' => 'CS401', 'name' => 'Artificial Intelligence', 'units' => 3, 'course' => 'BSCS', 'year_level' => '4th Year'],
            
            // Information Technology subjects
            ['code' => 'IT101', 'name' => 'IT Fundamentals', 'units' => 3, 'course' => 'BSIT', 'year_level' => '1st Year'],
            ['code' => 'IT102', 'name' => 'Computer Networks', 'units' => 3, 'course' => 'BSIT', 'year_level' => '1st Year'],
            ['code' => 'IT201', 'name' => 'System Analysis and Design', 'units' => 3, 'course' => 'BSIT', 'year_level' => '2nd Year'],
            ['code' => 'IT202', 'name' => 'Information Security', 'units' => 3, 'course' => 'BSIT', 'year_level' => '2nd Year'],
            ['code' => 'IT301', 'name' => 'Mobile App Development', 'units' => 3, 'course' => 'BSIT', 'year_level' => '3rd Year'],
            
            // Information Systems subjects
            ['code' => 'IS101', 'name' => 'Information Systems Fundamentals', 'units' => 3, 'course' => 'BSIS', 'year_level' => '1st Year'],
            ['code' => 'IS201', 'name' => 'Business Process Management', 'units' => 3, 'course' => 'BSIS', 'year_level' => '2nd Year'],
            
            // Business Administration subjects
            ['code' => 'BA101', 'name' => 'Principles of Management', 'units' => 3, 'course' => 'BSBA', 'year_level' => '1st Year'],
            ['code' => 'BA201', 'name' => 'Financial Accounting', 'units' => 3, 'course' => 'BSBA', 'year_level' => '2nd Year'],
            
            // Education subjects
            ['code' => 'ED101', 'name' => 'Foundations of Education', 'units' => 3, 'course' => 'BSEd', 'year_level' => '1st Year'],
            ['code' => 'ED201', 'name' => 'Educational Psychology', 'units' => 3, 'course' => 'BSEd', 'year_level' => '2nd Year'],
            
            // Nursing subjects
            ['code' => 'NS101', 'name' => 'Fundamentals of Nursing', 'units' => 4, 'course' => 'BSN', 'year_level' => '1st Year'],
            ['code' => 'NS201', 'name' => 'Medical-Surgical Nursing', 'units' => 5, 'course' => 'BSN', 'year_level' => '2nd Year'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}