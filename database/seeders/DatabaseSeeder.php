<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(MentorSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MessageSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(AssignedTaskSeeder::class);
        $this->call(KeySeeder::class);
        $this->call(ChatSeeder::class);
    }
}
