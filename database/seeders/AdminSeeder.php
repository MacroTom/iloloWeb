<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'id' => 1,
            'firstname' => 'Okeoghene',
            'lastname' => 'Esieba',
            'email' => 'okecoc1@gmail.com',
            'phone' => '09078533114',
            'avatar' => 'https://lineone.piniastudio.com/images/avatar/avatar-12.jpg',
            'role' => 1,
            'password' => Hash::make('test1234'),
        ]);

        \App\Models\User::factory()->create([
            'id' => 1,
            'firstname' => 'Lawrence',
            'lastname' => 'Pius',
            'email' => 'enaspius@gmail.com',
            'phone' => '07038579027',
            'role' => 1,
            'password' => Hash::make('test1234'),
        ]);
    }
}
