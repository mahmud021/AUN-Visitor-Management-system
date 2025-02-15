<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $user = User::create([
            'first_name' => 'Mahmud',
            'last_name'  => 'Modibbo',
            'email'      => 'test@example.com',
            'password'   => Hash::make('password'), // Provide a default password
        ]);

        UserDetails::create([
            'user_id'   => $user->id,
            'school_id' => 'A00023961', // Ensure this is unique as required
            'role'      => 'superadmin',
            'status'    => 'active',
            'telephone' => 1234567890,
        ]);
    }

}
