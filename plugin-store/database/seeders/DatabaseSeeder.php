<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Category seeder ko call kar rahay hain
        $this->call([
            CategorySeeder::class,
        ]);
        
        // Ek admin user bhi create kar lete hain taake dashboard access ho sake
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@plugin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '03000000000'
        ]);
    }
}