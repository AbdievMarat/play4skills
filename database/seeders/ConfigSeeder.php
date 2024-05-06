<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            [
                "id" => Config::CONFIG_QUESTION_ID,
                "name" => "Название заголовка",
                "value" => "Задай вопрос"
            ],
            [
                "id" => Config::CONFIG_QUESTION_DESCRIPTION_ID,
                "name" => "Текст описания",
                "value" => "Для получения ключа необходимо выполнить задание"
            ],
        ];

        foreach ($configs as $config) {
            Config::factory()
                ->state($config)
                ->create();
        }
    }
}
