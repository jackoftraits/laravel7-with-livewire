# laravel Livewire

https://www.youtube.com/watch?v=4muQp-nB0ZQ&list=PLSP81gW0XjNFP8RTBLMb1KL7Qbr8hUjr4

## quick install

- composer update
- cp .env.example .env
- php artisan key:generate
- touch database/database.sqlite
- in .env file replace 

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

with 

DB_CONNECTION=sqlite
```

- php artisan migrate:fresh --seed
- php artisan serve
- php artisan storage:link
- open browser on http://127.0.0.1:8000
