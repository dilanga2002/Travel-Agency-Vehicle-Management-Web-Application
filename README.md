# Sritravel

A web application for vehicle and driver management, built with [Laravel](https://laravel.com/).

## Features

- Vehicle management (add, edit, delete vehicles)
- Driver management (add, edit, delete drivers)
- Image upload with drag-and-drop and preview
- User authentication
- Responsive UI with Tailwind CSS

## Requirements

- PHP ^8.2
- Composer
- Node.js & npm

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/your-username/sritravel.git
   cd sritravel
   ```

2. **Install PHP dependencies:**
   ```sh
   composer install
   ```

3. **Install JavaScript dependencies:**
   ```sh
   npm install
   ```

4. **Copy `.env` file and set up environment variables:**
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run migrations:**
   ```sh
   php artisan migrate
   ```

6. **Start the development server:**
   ```sh
   php artisan serve
   ```

7. **Build frontend assets:**
   ```sh
   npm run dev
   ```

## Running Tests

```sh
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

> Powered by Laravel
