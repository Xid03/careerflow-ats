# CareerFlow ATS

CareerFlow ATS is a web-based applicant tracking system built for job seekers who want a cleaner, smarter alternative to spreadsheets and notebooks. It helps users manage job applications, interviews, reminders, salary expectations, and progress across the job-search pipeline.

This project is designed as a beginner-to-intermediate portfolio piece that demonstrates real product thinking, clean Laravel structure, relational database design, dashboard analytics, and user-focused workflows.

## Project Overview

### Problem
Job seekers often track applications in Excel, notes apps, or memory. That makes it difficult to:

- see which companies they already applied to
- remember follow-ups
- track interviews and offers
- compare salary expectations and outcomes
- understand job-search momentum at a glance

### Solution
CareerFlow ATS gives each user a private dashboard where they can:

- create and manage job applications
- update statuses through the hiring pipeline
- record interview rounds
- schedule reminders and follow-ups
- review salary trends and dashboard insights
- export their data to CSV

## Core Features

- Secure authentication with Laravel Breeze
- Application CRUD with ownership rules
- Search and filter by company, role, and status
- Interview tracking with timeline view
- Reminder scheduling, completion, and cleanup
- Status history timeline with optional status notes
- Dashboard metrics for pipeline activity
- Visual analytics for status distribution and monthly application activity
- Salary snapshot for expected and offered compensation
- CSV export for filtered application data
- Seeded demo portfolio data

## Tech Stack

- Backend: PHP 8.3, Laravel 13
- Frontend: Blade, Tailwind CSS, Alpine.js, Vite
- Database: SQLite for local development
- Testing: PHPUnit

## Data Model

Main entities:

- `users`
- `companies`
- `applications`
- `interviews`
- `reminders`
- `application_status_histories`

Key relationships:

- one user has many applications
- one company has many applications
- one application has many interviews
- one application has many reminders
- one application has many status history entries

## Main Screens

- Login and registration
- Dashboard overview
- Applications list
- Create and edit application form
- Application detail page

## Dashboard Highlights

- Total applications
- Pending applications
- Upcoming interviews
- Overdue reminders
- Offers received
- Status distribution
- Monthly application activity
- Salary snapshot

## Demo Account

The project includes seeded portfolio data.

- Email: `demo@careerflow.test`
- Password: `password`

## Local Setup

### 1. Install dependencies

```bash
composer install
npm install
```

### 2. Create environment file

```bash
copy .env.example .env
php artisan key:generate
```

### 3. Configure database

This project is currently configured to use SQLite locally.

Active local database file:

- `storage/private/careerflow.sqlite`

### 4. Run migrations and seed demo data

```bash
php artisan migrate
php artisan db:seed
```

### 5. Start the app

In one terminal:

```bash
php -S 127.0.0.1:8080 -t public
```

In a second terminal:

```bash
npm run dev
```

Then open:

- `http://127.0.0.1:8080`

## Windows Notes

This project was developed and tested on Windows. If `php artisan serve` fails to bind to a port on your machine, use:

```bash
php -S 127.0.0.1:8080 -t public
```

## Email Setup

### Local development

By default, this project uses:

```bash
MAIL_MAILER=log
```

That means password reset emails are written to:

- `storage/logs/laravel.log`

This is useful for local testing when you do not want to send real email.

### Production / deployed app with Resend

For a hosted version of CareerFlow ATS, the recommended mail provider is `Resend`.

1. Install the required packages:

```bash
composer require resend/resend-php symfony/http-client
```

2. Set these environment variables on your server or hosting platform:

```bash
APP_URL=https://your-domain.com
MAIL_MAILER=resend
RESEND_API_KEY=re_xxxxxxxxxxxxxxxxx
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="CareerFlow ATS"
```

3. Clear cached config after updating environment values:

```bash
php artisan config:clear
```

4. Make sure your sender domain is verified inside your Resend account.

Once this is configured, forgot-password emails and other future notifications will be delivered as real emails instead of being written to the log file.

## Testing

Run the test suite with:

```bash
php artisan test
```

Current tested areas include:

- application CRUD
- ownership checks
- status history
- CSV export
- dashboard analytics
- reminder management
- interview management

## Sample User Flows

### Application tracking

1. Create an application
2. Update its status
3. Add a status note
4. Review the status history timeline

### Interview tracking

1. Add an interview round
2. Update interview details
3. Delete obsolete interview entries

### Reminder workflow

1. Add a follow-up reminder
2. Mark it complete
3. Track overdue reminders from the dashboard

## Portfolio Value

This project demonstrates:

- clean Laravel MVC structure
- reusable Blade components and layouts
- custom validation and friendly error feedback
- relational SQL design and one-to-many relationships
- dashboard reporting and analytics
- authorization based on record ownership
- realistic seeded data for demos and screenshots

## Suggested Screenshots

For portfolio presentation, capture:

- login page
- dashboard overview
- applications list with filters
- create application form
- application detail page
- interview and reminder sections
- status history timeline
- CSV export in spreadsheet view

## Future Improvements

- dedicated reports page
- advanced date and salary filters
- recruiter and contact management
- saved filter presets
- email or in-app reminder notifications
- file attachments for resumes or cover letters
- richer chart visualizations with a charting library

## Author Notes

CareerFlow ATS was scoped to stay realistic for one developer while still looking polished and portfolio-worthy. The focus was on useful workflows, clean code, relational data modeling, and a professional user experience rather than overbuilding unnecessary complexity.
