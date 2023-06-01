<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory()->state(['name' => 'admin', 'description' => 'Администратор'])->create();
        Role::factory()->state(['name' => 'moderator', 'description' => 'Модератор'])->create();
        Role::factory()->state(['name' => 'student', 'description' => 'Участник'])->create();
    }
}
