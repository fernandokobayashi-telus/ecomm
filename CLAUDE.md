# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Environment

This project uses **Laravel Sail** (Docker Compose) for local development. All commands should be run via `sail` or directly inside the container.

Start all services:
```bash
./vendor/bin/sail up -d
```

Start the full dev stack (PHP server + queue + logs + Vite):
```bash
composer dev
```

## Common Commands

| Task | Command |
|------|---------|
| Run tests | `composer test` |
| Run a single test file | `./vendor/bin/phpunit tests/Feature/SomeTest.php` |
| Run a single test method | `./vendor/bin/phpunit --filter testMethodName` |
| Build frontend assets | `npm run build` |
| Frontend dev server | `npm run dev` |
| Artisan commands | `php artisan <command>` (or `./vendor/bin/sail artisan`) |
| Database migrations | `php artisan migrate` |
| Fresh migrate + seed | `php artisan migrate:fresh --seed` |

`composer test` clears config cache then runs PHPUnit with the `phpunit.xml` configuration.

## Architecture

**Stack**: Laravel 13 / PHP 8.3+ backend, Blade + Tailwind CSS 4.0 frontend, Vite build tool.

**Services (Docker)**:
- MySQL 8.4 — primary database
- Redis — caching and sessions
- Meilisearch — full-text search (Laravel Scout)
- Mailpit — email testing (UI at port 8025)
- Selenium — browser automation

**Key patterns**:
- MVC structure under `app/Http/Controllers/`, `app/Models/`
- Queue jobs are database-backed; worker runs via `php artisan queue:listen`
- Sessions are database-backed
- Frontend entry points: `resources/css/app.css` (Tailwind) and `resources/js/app.js`

## Testing

- Unit tests: `tests/Unit/` — isolated logic tests
- Feature tests: `tests/Feature/` — full HTTP/integration tests
- Test DB uses SQLite in-memory (`DB_DATABASE=testing` in `phpunit.xml`)
- Mocking via Mockery; HTTP testing via Laravel's built-in test helpers
