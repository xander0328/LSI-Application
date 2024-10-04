<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // User::create([
        //     'fname' => "LSI Administrator",
        //     'mname' => "",
        //     'lname' => "",
        //     'contact_number' => "",
        //     'email' => "lsi.ormin.ekonek@gmail.com",
        //     'password' => Hash::make('Lsi.Admin@2024'), // Hash the password
        //     'role' => "superadmin",
        // ]);

        // for ($i = 0; $i < 40; $i++) {
        //     User::create([
        //         'fname' => $faker->firstName,
        //         'mname' => $faker->lastName,
        //         'lname' => $faker->lastName,
        //         'contact_number' => '09' . $faker->numberBetween(10000000, 99999999),
        //         'email' => $faker->unique()->safeEmail,
        //         'password' => Hash::make('Lsi@2024'), // Hash the password
        //         'role' => "guest",
        //     ]);
        // }

        // User::create([
        //     'fname' => "Reynalda",
        //     'mname' => "",
        //     'lname' => "Manansala",
        //     'contact_number' => '09' . $faker->numberBetween(10000000, 99999999),
        //     'email' => "reynalda.manansala@gmail.com",
        //     'password' => Hash::make('Lsi.Trainer@2024'), // Hash the password
        //     'role' => "instructor",
        // ]);

        // User::create([
        //     'fname' => "Pauline Maegan",
        //     'mname' => "",
        //     'lname' => "Cual",
        //     'contact_number' => '09' . $faker->numberBetween(10000000, 99999999),
        //     'email' => "pauline.cual@gmail.com",
        //     'password' => Hash::make('Lsi.Trainer@2024'), // Hash the password
        //     'role' => "instructor",
        // ]);
        
        User::create([
            'fname' => "Student 1",
            'mname' => "",
            'lname' => "Sample",
            'contact_number' => '09' . $faker->numberBetween(10000000, 99999999),
            'email' => "student1@gmail.com",
            'password' => Hash::make('password'), // Hash the password
            'role' => "student",
        ]);
    }
}
