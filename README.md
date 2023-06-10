touch database/database.sqlite

cp .env.example .env

.env -> DB_CONNECTION=sqlite

composer install

npm install && npm run dev

php artisan storage:link

php artisan migrate --seed

php artisan ui bootstrap --auth

для настройки локализации:
https://laravel-lang.com/installation/

composer require laravel-lang/common --dev
php artisan lang:add fr
php artisan lang:update
