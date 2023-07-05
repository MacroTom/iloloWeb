<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(100)->create();

        \App\Models\User::factory()->create([
            'firstname' => 'Okeoghene',
            'lastname' => 'Esieba',
            'email' => 'okecoc1@gmail.com',
            'phone' => '09078533114',
            'avatar' => 'https://lineone.piniastudio.com/images/avatar/avatar-12.jpg',
            'role' => 1,
            'password' => Hash::make('test1234'),
        ]);
    }
}
