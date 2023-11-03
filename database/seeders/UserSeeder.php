<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        $studentRole = Role::query()->where('name', '=', 'student')->first();

        $users = [
            ["name" => "Команда 1", "email" => "command1@play.com", "decrypted_password" => "B9npEq", "password" => Hash::make('B9npEq')],
            ["name" => "Команда 2", "email" => "command2@play.com", "decrypted_password" => "MB7ESg", "password" => Hash::make('MB7ESg')],
            ["name" => "Команда 3", "email" => "command3@play.com", "decrypted_password" => "2oXKR9", "password" => Hash::make('2oXKR9')],
            ["name" => "Команда 4", "email" => "command4@play.com", "decrypted_password" => "wMFux4", "password" => Hash::make('wMFux4')],
            ["name" => "Команда 5", "email" => "command5@play.com", "decrypted_password" => "bPSsxl", "password" => Hash::make('bPSsxl')],
            ["name" => "Команда 6", "email" => "command6@play.com", "decrypted_password" => "oDvDDP", "password" => Hash::make('oDvDDP')],
            ["name" => "Команда 7", "email" => "command7@play.com", "decrypted_password" => "BOLczG", "password" => Hash::make('BOLczG')],
        ];

        foreach ($users as $user) {
            User::factory()
                ->state($user)
                ->hasAttached($studentRole)
                ->create();
        }
    }
}
