### Setup

```bash
cp .env.example .env
php artisan key:generate
composer install
php artisan migrate --seed
npm install
php artisan serve
npm run dev
```

### Factories

```bash
php artisan factory:properties 50 
```