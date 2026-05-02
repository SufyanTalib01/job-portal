<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PHPUnit\Util\PHP\Job;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\Category::factory(5)->create();
        \App\Models\JobType::factory(5)->create();
    }
}
