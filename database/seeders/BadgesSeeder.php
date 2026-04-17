<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Badge::insert([
            ['name' => 'Bronze', 'achievements_required' => 1],
            ['name' => 'Silver', 'achievements_required' => 2],
            ['name' => 'Gold', 'achievements_required' => 3],
        ]);
    }
}
