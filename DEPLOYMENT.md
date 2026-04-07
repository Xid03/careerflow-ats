# Deployment Guide

This project is ready to deploy as a portfolio/demo app.

## Recommended platform

- Render Web Service with Docker
- Alternative: Laravel Cloud

## Before deploying

1. Push the repository to GitHub.
2. Use a production database:
- PostgreSQL recommended
3. Use a real mail provider:
- Resend recommended
4. Keep `APP_DEBUG=false`

## Render deployment

Render does not provide a native PHP runtime for this project flow, so deploy it as a Docker web service using the included `Dockerfile`.

Use these Render settings:

- Service type: `Web Service`
- Environment: `Docker`
- Branch: `main`
- Dockerfile path: `./Dockerfile`

## Required production environment values

Use `.env.production.example` as the template.

Important values:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=pgsql
DB_HOST=...
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=...
DB_PASSWORD=...

MAIL_MAILER=resend
RESEND_API_KEY=re_xxxxxxxxxxxxxxxxx
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="CareerFlow ATS"

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

## Required package for Resend

Install before production deploy:

```bash
composer require resend/resend-php symfony/http-client
```

## Build and deploy flow

Render will build the Docker image automatically.

The container start command already runs:

- `php artisan migrate --force`
- `php -S 0.0.0.0:$PORT -t public`

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

Do not deploy the local SQLite setup as the public version. Keep SQLite for local development and use a managed PostgreSQL database such as Supabase for hosting.
