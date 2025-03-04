<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = [
            'Juan', 'Maria', 'Jose', 'Ana', 'Pedro', 'Rosa', 'Carlos', 'Lourdes', 'Antonio', 'Teresa',
            'Manuel', 'Sofia', 'Ricardo', 'Isabel', 'Eduardo', 'Juana', 'Francisco', 'Elena', 'Angelo', 'Luisa',
            'Miguel', 'Carmen', 'Gabriel', 'Patricia', 'Rafael', 'Rosario', 'Daniel', 'Remedios', 'Ernesto', 'Josephine'
        ];

        $lastNames = [
            'Garcia', 'Santos', 'Reyes', 'Cruz', 'Bautista', 'Gonzales', 'Ramos', 'Aquino', 'Mendoza', 'Torres',
            'Flores', 'Lopez', 'Diaz', 'Hernandez', 'Castro', 'Rivera', 'Villanueva', 'Tan', 'Dela Cruz', 'Domingo',
            'Espiritu', 'Pascual', 'Ferrer', 'Aguilar', 'Marquez', 'Navarro', 'Santiago', 'Salazar', 'Valdez', 'Miranda'
        ];

        $courses = ['BSCS', 'BSIT', 'BSIS', 'BSBA', 'BSEd', 'BSN'];
        $yearLevels = ['1st Year', '2nd Year', '3rd Year', '4th Year'];
        
        // Generate 50 students with BukSU format IDs
        for ($i = 1; $i <= 50; $i++) {
            // Generate student ID in format YYNN##### (YY=year, NN=department, #####=sequence)
            $year = rand(19, 23); // Years 2019-2023
            $dept = str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT);
            $sequence = str_pad($i, 5, '0', STR_PAD_LEFT);
            
            $studentId = $year . $dept . $sequence;
            
            // Generate a random name
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = $firstName . ' ' . $lastName;
            
            // Select a random course and year level
            $course = $courses[array_rand($courses)];
            $yearLevel = $yearLevels[array_rand($yearLevels)];
            
            User::create([
                'student_id' => $studentId,
                'name' => $name,
                'email' => $studentId . '@student.buksu.edu.ph',
                'password' => Hash::make('123123123'),
                'role' => 'student',
                'course' => $course,
                'year_level' => $yearLevel,
                'email_verified_at' => now(),
            ]);
        }
    }
}