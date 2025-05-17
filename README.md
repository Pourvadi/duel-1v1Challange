# Duel System API

A simple and efficient API for managing and sending duels between users, built with the Laravel framework and token-based authentication using Laravel Sanctum. This API allows sending, accepting, and rejecting duel requests.

---

## Features

- User authentication with token-based login (Sanctum)
- Send duel requests to other users
- Accept or reject duel requests
- View the list of sent duel requests

---

## Requirements

- PHP 8.0 or higher
- Composer
- Laravel 9 or higher
- Database (MySQL or SQLite)
- Postman or a similar tool for API testing

---

## Installation & Setup

```bash
git clone https://github.com/Pourvadi/duel-system.git
cd duel-system
composer install

php artisan migrate
php artisan serve
