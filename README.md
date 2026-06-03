# My-Taxi

Laravel app for long-distance taxi reservations.

## Features
- Voyageur and courtier roles
- Trajets shown only for the next 24 hours
- Search by departure and arrival city
- Reservation with waiting list and auto-promotion
- Courtier CRUD for trajets
- Demo payment flag only, no real payment gateway

## Tech Stack
- Laravel 12
- PHP 8.2
- MySQL
- Breeze auth (Blade)
- Bootstrap 5

## Local Setup
1. Start Apache and MySQL from XAMPP.
2. Open the project in `C:\xampp\htdocs\main`.
3. Make sure `.env` is configured for MySQL.
4. Run migrations and seeders if needed:

```bash
C:\xampp\php\php.exe artisan migrate:fresh --seed
```

## Run Locally
Use one of these URLs:
- `http://localhost/main/public`
- `http://127.0.0.1:8000` if you run `php artisan serve`

## Demo Accounts
- Courtier: `courtier@mytaxi.ma` / `password`
- Voyageurs:
  - `sara@gmail.ma` / `password`
  - `youssef@gmail.ma` / `password`
  - `karim@gmail.ma` / `password`
  - `fatima@gmail.ma` / `password`

## Main Routes
- `/` homepage
- `/trajets` public ride list
- `/login` auth
- `/courtier/dashboard` courtier area

## Notes
- The project folder is already inside `C:\xampp\htdocs\main`.
- If changes do not appear in the browser, restart Apache.
