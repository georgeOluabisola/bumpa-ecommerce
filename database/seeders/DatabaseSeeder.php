<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AchievementsSeeder;
use Database\Seeders\BadgesSeeder;
use Database\Seeders\UsersSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(
            [
                AchievementsSeeder::class,
                BadgesSeeder::class,
                UsersSeeder::class,
            ]
        );
        // User::factory(10)->create();


    }
}
