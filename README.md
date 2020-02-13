<b>To start</b>
<p>Configure .env with MySQL credentials.</p>

```bash
> composer install
> php artisan optimize
> php artisan migrate
> php artisan serve
> php artisan db:seed
```

<b>Command:</b>

```bash
php artisan subscribers:report {YYYY-MM-DD}
```

<b>End-points:</b>

| Method    |  End-point | Fields  | Descripction |
| ------------ | ------------ | ------------ | ------------ |
| DELETE   | http://localhost:8000/api/v1/subscription/user/{user_id}/service/{service_id} |  - | Remove a subscriber. |
| POST | http://localhost:8000/api/v1/subscription/  | user_id service_id  | Add a subscriber |

<p>Enjoy!</p>
