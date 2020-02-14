mv .env.example .env
run tests: phpunit
migrates&seeds php artisan migrate:fresh && php artisan db:seed
