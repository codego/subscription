<b>To start</b>
```
composer install
php artisan optimize
php artisan migrate
php artisan serve
php artisan db:seed
```
<p>Enjoy...</p>
<br />
<b>Command:</b>
<p>php artisan subscribers:report {YYYY-MM-DD}</p>.
<br>
<b>End-points:</b>
```POST``` http://localhost:8000/api/subscription/
expected fields: ```user_id``` ```service_id```
<br/>
```DELETE``` http://localhost:8000/api/subscription/user/{user_id}/service/{service_id}
