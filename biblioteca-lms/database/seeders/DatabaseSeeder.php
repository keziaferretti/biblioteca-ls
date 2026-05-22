<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Admin User',
            'email' => 'admin@biblioteca-lms.test',
        ]);

        $this->call([
            PublisherSeeder::class,
            BookSeeder::class,
            CustomerSeeder::class,
            LoanSeeder::class,
        ]);
    }
}
