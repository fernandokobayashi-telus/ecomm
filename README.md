# eComm — Laravel E-Commerce Playground

A full-featured e-commerce application built with Laravel 13, Blade, and Tailwind CSS 4. This project serves as a playground for exploring modern patterns and agentic development with tools like Laravel Boost.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.3+ / Laravel 13 |
| Frontend | Blade Templates + Tailwind CSS 4 |
| Build Tool | Vite 8 |
| Database | MySQL 8.4 |
| Cache & Sessions | Redis |
| Search | Meilisearch (Laravel Scout) |
| Email Testing | Mailpit (UI at port 8025) |
| Browser Automation | Selenium |
| Local Dev | Laravel Sail (Docker) |

---

## Getting Started

### Prerequisites

- Docker Desktop
- Composer
- Node.js / npm

### Setup

```bash
# Start Docker services
./vendor/bin/sail up -d

# Run migrations and seed the database
./vendor/bin/sail artisan migrate --seed

# Install JS dependencies and build assets
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

### Running the Dev Stack

Start the full development stack (PHP server + queue worker + log viewer + Vite):

```bash
./vendor/bin/sail composer dev
```

Or start services individually:

```bash
# Docker services
./vendor/bin/sail up -d

# Frontend dev server (hot reload)
./vendor/bin/sail npm run dev

# Queue worker
./vendor/bin/sail artisan queue:listen

# Log viewer
./vendor/bin/sail artisan pail
```

---

## Common Commands

| Task | Command |
|------|---------|
| Run all tests | `composer test` |
| Run a single test file | `./vendor/bin/sail artisan test tests/Feature/SomeTest.php` |
| Run a filtered test | `./vendor/bin/sail artisan test --filter=testMethodName` |
| Build frontend assets | `./vendor/bin/sail npm run build` |
| Fresh migrate + seed | `./vendor/bin/sail artisan migrate:fresh --seed` |
| List routes | `./vendor/bin/sail artisan route:list` |
| Run Pint (code formatter) | `./vendor/bin/sail bin pint --dirty` |

---

## Seeded Data

After running `migrate --seed`, the database is populated with:

- **1 Super Admin** — `admin@admin.com` / `admin123`
- **5 dummy users** (faker-generated)
- **5 root categories** (Electronics, Clothing, Home & Living, Sports, Books), each with **3 subcategories**
- **150 products** distributed across categories, 25 with images

---

## Features

### Storefront

- **Home page** — hero banner, featured products carousel, new arrivals section, category sidebar, newsletter signup
- **Product listing** — responsive grid with all products
- **Product detail** — full description, price (formatted from cents), associated categories
- **Category browsing** — hierarchical category tree (up to 2 levels), products per category

### Authentication

- User registration (assigned `user` role by default)
- Login with "remember me" support
- Session-based auth

### User Dashboard

- **Profile management** — update name and phone number
- **Password change** — requires current password verification
- **Shipping addresses** — add, edit, delete multiple addresses; mark one as default

### Admin Panel (`/admin`)

Accessible to `super_admin` and `product_admin` roles:

- **Products** — full CRUD, auto-slug generation, category assignment (many-to-many), cent-based pricing
- **Categories** — full CRUD, hierarchical structure (max 2 levels), auto-slug generation

Accessible to `super_admin` only:

- **User management** — list users, edit name/email/role, delete users (self-deletion protected)

### Role-Based Access Control

| Role | Access |
|------|--------|
| `super_admin` | Full admin access including user management |
| `product_admin` | Product and category management |
| `sales_admin` | Reserved for future sales features |
| `user` | Storefront + personal dashboard only |

---

## Project Structure

```
app/
├── Enums/UserRole.php          # Role enum (super_admin, user, product_admin, sales_admin)
├── Http/Controllers/
│   ├── Admin/                  # Admin controllers (products, categories, users)
│   ├── Auth/                   # Login & register controllers
│   ├── HomeController.php
│   ├── ProductController.php
│   ├── CategoryController.php
│   ├── DashboardController.php
│   ├── ProfileController.php
│   └── ShippingAddressController.php
└── Models/
    ├── User.php
    ├── Product.php
    ├── Category.php
    └── ShippingAddress.php

resources/views/
├── layouts/app.blade.php       # Master layout
├── home.blade.php              # Home page with partials
├── products/                   # Product listing & detail
├── categories/                 # Category listing & detail
├── dashboard.blade.php         # User account dashboard
├── auth/                       # Login & register forms
└── admin/                      # Admin panel views

routes/web.php                  # All application routes
```

---

## Agentic Development

This project uses [Laravel Boost](https://laravel.com/docs/ai) to supercharge AI-assisted development:

Boost provides 15+ MCP tools and skills that help agents build Laravel applications while following best practices — database inspection, log reading, semantic documentation search, and more.

---

## License

MIT
