<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            CategorySeeder::class,
        ]);
        
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@plugin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '03000000000'
        ]);
    }
}