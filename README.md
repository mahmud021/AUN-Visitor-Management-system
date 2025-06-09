# AUN Visitor Management System

A visitor and inventory management application built on **Laravel 11**. It helps manage people coming into the campus and keeps track of equipment.

## Features

- User role management
- Visitor appointments and walk‑in registration
- QR code scanning for quick check in/out
- Inventory tracking
- Timeline events with analytics

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Development Server

Start everything with:

```bash
composer dev
```

This runs the Laravel server, queue listener, log tailer, and Vite in one command. Alternatively you can use:

```bash
php artisan serve &
npm run dev
```

## Running Tests

Execute the test suite with:

```bash
./vendor/bin/pest
```

