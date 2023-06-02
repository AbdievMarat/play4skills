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
            ["name" => "Мамедова Назик", "email" => "nazik.mamedova@cci.com.kg", "decrypted_password" => "B9npEq", "password" => Hash::make('B9npEq')],
            ["name" => "Аземкулов Бахтияр", "email" => "bakhtiiar.azemkulov@cci.com.kg", "decrypted_password" => "MB7ESg", "password" => Hash::make('MB7ESg')],
            ["name" => "Жумабаева Мээрим", "email" => "meerim.zhumabaeva@cci.com.kg", "decrypted_password" => "2oXKR9", "password" => Hash::make('2oXKR9')],
            ["name" => "Карыпкулов Иман", "email" => "iman.karypkulov@cci.com.kg", "decrypted_password" => "wMFux4", "password" => Hash::make('wMFux4')],
            ["name" => "Лисицына Анастасия", "email" => "anastasiia.lisitsyna@cci.com.kg", "decrypted_password" => "bPSsxl", "password" => Hash::make('bPSsxl')],
            ["name" => "Кадырова Елена", "email" => "elena.kadyrova@cci.com.kg", "decrypted_password" => "oDvDDP", "password" => Hash::make('oDvDDP')],
            ["name" => "Клычев Темирлан", "email" => "temirlan.klychev@cci.com.kg", "decrypted_password" => "BOLczG", "password" => Hash::make('BOLczG')],
            ["name" => "Шавкатова Асема", "email" => "asema.shavkatova@cci.com.kg", "decrypted_password" => "jgGsCJ", "password" => Hash::make('jgGsCJ')],
            ["name" => "Дженишова Бегимай", "email" => "begimai.dzhenishova@cci.com.kg", "decrypted_password" => "DeYkOO", "password" => Hash::make('DeYkOO')],
            ["name" => "Качкынбаев Чынгыз", "email" => "chyngyz.kachkynbaev@cci.com.kg", "decrypted_password" => "JDwhPt", "password" => Hash::make('JDwhPt')],
            ["name" => "Клименко Виктория", "email" => "viktoriya.klimenko@cci.com.kg", "decrypted_password" => "Jr4DPM", "password" => Hash::make('Jr4DPM')],
            ["name" => "Сайткулов Шаршенали", "email" => "sharshenali.saitkulov@cci.com.kg", "decrypted_password" => "JsFYKr", "password" => Hash::make('JsFYKr')],
            ["name" => "Сейдакматова Нурида", "email" => "nurida.seidakmatova@cci.com.kg", "decrypted_password" => "bmzDvJ", "password" => Hash::make('bmzDvJ')],
            ["name" => "Акматов Максат", "email" => "maksat.akmatov@cci.com.kg", "decrypted_password" => "iHEMzw", "password" => Hash::make('iHEMzw')],
            ["name" => "Маширбаева Наталья", "email" => "natalia.mashirbaeva@cci.com.kg", "decrypted_password" => "RrBv8D", "password" => Hash::make('RrBv8D')],
            ["name" => "Ворошкова Инга", "email" => "inga.beskorovainaia@cci.com.kg", "decrypted_password" => "HTJaDc", "password" => Hash::make('HTJaDc')],
            ["name" => "Ермакова Мария", "email" => "mariia.ermakova@cci.com.kg", "decrypted_password" => "1Rrjju", "password" => Hash::make('1Rrjju')],
            ["name" => "Шаадаев Фархат", "email" => "farhat.shaadaev@cci.com.kg", "decrypted_password" => "7C3Txj", "password" => Hash::make('7C3Txj')],
            ["name" => "Карпенко Николай", "email" => "nikolai.karpenko@cci.com.kg", "decrypted_password" => "6K8nx8", "password" => Hash::make('6K8nx8')],
            ["name" => "Кудайбергенов Нурлан", "email" => "nurlan.kudaibergenov@cci.com.kg", "decrypted_password" => "IgBW78", "password" => Hash::make('IgBW78')],
            ["name" => "Ибраимов Бактияр", "email" => "baktiyar.ibraimov@cci.com.kg", "decrypted_password" => "JjXqP0", "password" => Hash::make('JjXqP0')],
            ["name" => "Нурадилов Улукбек", "email" => "ulukbek.nuradilov@cci.com.kg", "decrypted_password" => "J0lp6d", "password" => Hash::make('J0lp6d')],
            ["name" => "Жумабек уулу Аскат ", "email" => "askat.jumabekuulu@cci.com.kg", "decrypted_password" => "ErloZ2", "password" => Hash::make('ErloZ2')],
            ["name" => "Ибраимов Азат", "email" => "azat.ibraimov@cci.com.kg", "decrypted_password" => "1ORXlL", "password" => Hash::make('1ORXlL')],
            ["name" => "Шарапов Мирлан", "email" => "mirlan.sharapov@cci.com.kg", "decrypted_password" => "2pS1da", "password" => Hash::make('2pS1da')],
            ["name" => "Черкашин Владимир", "email" => "vladimir.cherkashin@cci.com.kg", "decrypted_password" => "psT0OU", "password" => Hash::make('psT0OU')],
            ["name" => "Юсуров Идрис", "email" => "Idris.Yusurov@cci.com.kg", "decrypted_password" => "riDkIY", "password" => Hash::make('riDkIY')],
            ["name" => "Литвиненко Евгений", "email" => "evgenii.litvinenko@cci.com.kg", "decrypted_password" => "PhItqB", "password" => Hash::make('PhItqB')],
            ["name" => "Кошбаев Субаналы", "email" => "subanaly.koshbaev@cci.com.kg", "decrypted_password" => "KpW1L0", "password" => Hash::make('KpW1L0')],
            ["name" => "Мамишов Ниязбек", "email" => "niiazbek.mamishov@cci.com.kg", "decrypted_password" => "RNxgOi", "password" => Hash::make('RNxgOi')],
            ["name" => "Чугуев Антон", "email" => "anton.chuguev@cci.com.kg", "decrypted_password" => "PIwKyl", "password" => Hash::make('PIwKyl')],
        ];

        foreach ($users as $user) {
            User::factory()
                ->state($user)
                ->hasAttached($studentRole)
                ->create();
        }
    }
}
