<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'], // Prevents duplicate entries
            [
                'first_name' => 'Mahmud',
                'last_name'  => 'Modibbo',
                'password'   => Hash::make('password'),
            ]
        );

        UserDetails::firstOrCreate(
            ['user_id' => $user->id], // Prevents duplicate entries
            [
                'school_id' => 'A00023961', // Ensure this is unique
                'role'      => 'super admin',
                'status'    => 'Enrolled',
                'telephone' => '1234567890', // Change from integer to string
            ]
        );
    }
}
