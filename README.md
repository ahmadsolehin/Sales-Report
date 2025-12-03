# Product Order Summary Report

A small Laravel application that generates a **Product Order Summary Report** with:

- Date range filter (start / end date)
- Summary metrics (Total Orders, Total Revenue, Average Order Value)
- Top 3 best-selling products
- Detailed orders table with server-side pagination & search (Yajra DataTables)
- Excel export that includes:
  - A summary section at the top (with merged cells)
  - A detailed table section below

---

## Tech Stack

- PHP 8.2+
- Laravel 11
- MySQL 8 (or compatible)
- Composer

### Main Packages

- [`yajra/laravel-datatables-oracle`](https://github.com/yajra/laravel-datatables-oracle) – server-side DataTables
- [`maatwebsite/excel`](https://github.com/Maatwebsite/Laravel-Excel) – Excel export

---

## Installation Steps

1. **Clone or unzip the project**

   ```bash
   git clone <your-repo-url> sales-report
   cd sales-report

2. **Install PHP dependencies**

   ```bash
    composer install


3. **Create .env file**

   ```bash
    cp .env.example .env


4. **Configure environment**

   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sales_report
    DB_USERNAME=root
    DB_PASSWORD=


5. **Generate application key**

   ```bash
   php artisan key:generate


6. **Run migrations and seed data**

   ```bash
   php artisan migrate --seed


   ## Screenshots

![Index Page](screenshot/sales.png)

![Product Order Summary Report](screenshot/excel.png)
