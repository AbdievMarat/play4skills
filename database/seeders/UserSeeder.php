<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::query()->where('name', '=', 'admin')->first();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
        ])->roles()->attach($adminRole->id);

        $moderatorRole = Role::query()->where('name', '=', 'moderator')->first();
        $studentRole = Role::query()->where('name', '=', 'student')->first();

        User::factory()
            ->count(2)
            ->hasAttached($moderatorRole)
            ->create();
        User::factory()
            ->count(30)
            ->hasAttached($studentRole)
            ->create();
    }
}
