# Barangay Bulletin - Purok Domingo (Lab 11)

## Seeded Logins
- **Kagawad:** kagawad.domingo@bulletin.test | Password: password12345
- **Lola (Resident):** lola.domingo@bulletin.test | Password: password12345

## Seeded Tags
1. Purok Domingo
2. Urgent
3. Libre
4. Schedule
5. Health

## How to Run
1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`
4. `php artisan migrate:fresh --seed`
5. `npm install`
6. `npm run dev`
7. `php artisan serve` (or `php artisan serve --port=9000` if 8000 is busy. My previous Lab 10 did not run properly for awhile cuz of this)