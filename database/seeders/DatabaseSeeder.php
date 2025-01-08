<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'firstname' => 'Thomas',
            'lastname' => 'Claessens',
            'lang' => 'fr',
            'phone' => '+32486268598',
            'street' => 'Rue des Brebis',
            'street_number' => '71',
            'zip' => '1170',
            'country' => 'BE',
            'active' => true,
            'firstname' => 'Thomas',
            'email' => 'thomas.claessens@immovlan.be',
            'password' => bcrypt('password'),
        ]);
    }
}
