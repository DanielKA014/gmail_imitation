<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),  
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('emails')->insert([
                'subject' => 'Meeting Tomorrow',
                'body' => 'Hi team, lets meet tomorrow at 10 AM.',
                'from' => 'boss@company.com',
                'to' => 'employee@company.com',
                'is_favorite' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }
}
