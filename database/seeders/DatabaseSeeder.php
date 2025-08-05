<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Admin',
            'username' => 'KJordan',
            'email' => 'shadow902@gmail.com',
            'password' => Hash::make('Welc0me!1225'),
        ]);

        $user_profile = UserProfile::create([
            'user_id' => $user->id,
            'display_name' => 'temporary display name',
        ]);
    }
}
