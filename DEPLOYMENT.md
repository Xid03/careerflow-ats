# Deployment Guide

This project is ready to deploy as a portfolio/demo app.

## Recommended platform

- Laravel Cloud
- Alternative: DigitalOcean App Platform

## Before deploying

1. Push the repository to GitHub.
2. Use a production database:
- MySQL or PostgreSQL
3. Use a real mail provider:
- Resend recommended
4. Keep `APP_DEBUG=false`

## Required production environment values

Use `.env.production.example` as the template.

Important values:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=...
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

MAIL_MAILER=resend
RESEND_API_KEY=re_xxxxxxxxxxxxxxxxx
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="CareerFlow ATS"
```

## Required package for Resend

Install before production deploy:

```bash
composer require resend/resend-php symfony/http-client
```

## Build and deploy flow

1. Install dependencies

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

2. Run the Laravel deploy script

```bash
composer run deploy
```

That deploy script runs:

- `php artisan migrate --force`
- `php artisan config:cache`
- `php artisan route:cache`
- `php artisan view:cache`

## Health check

Laravel health endpoint:

```text
/up
```

Example:

```text
https://your-domain.com/up
```

## Smoke test after deploy

Test these flows:

1. Register
2. Login
3. Forgot password
4. Reset password
5. Create application
6. Add interview
7. Add reminder
8. Export CSV

## Important note

Do not deploy the local SQLite setup as the public version. Keep SQLite for local development and use a managed production database for hosting.
