<b>To start</b>
```bash
> php artisan optimize
> php artisan migrate
> php artisan serve
> php artisan db:seed
```
<br />
<b>Command:</b>

```bash
php artisan subscribers:report {YYYY-MM-DD}
```

| Method    |  End-point | Fields  | Descripction |
| ------------ | ------------ | ------------ | ------------ |
| DELETE   | http://localhost:8000/api/subscription/user/{user_id}/service/{service_id} |  - | Remove a subscriber. |
| POST | http://localhost:8000/api/subscription/  | user_id service_id  | Add a subscriber |

<p>Enjoy!</p>
