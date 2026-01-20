# Repository Guidelines

## Project Structure & Module Organization
Application logic stays in `app/` (`Http/Controllers`, `Models`, and `Policies`), while reusable domain services should live under `app/Services`. HTTP entry points are declared in `routes/web.php` for Blade-driven pages and `routes/api.php` for JSON endpoints. Front-end assets reside in `resources/js`, `resources/css`, and Blade templates in `resources/views`; compile output is written to `public/` via Vite. Database migrations, seeders, and factories are under `database/`, and automated checks belong in `tests/Feature` or `tests/Unit` with filenames ending in `Test.php`.

## Build, Test, and Development Commands
- `composer setup` – installs PHP deps, copies `.env`, generates the key, runs migrations, and builds the front end.
- `php artisan serve` (or `composer dev` for the full server/queue/vite stack) – launches the local stack; visit `http://127.0.0.1:8000`.
- `npm run dev` / `npm run build` – run Vite in watch mode or produce versioned assets.
- `php artisan migrate --seed` – applies schema changes and seeds reference data.

## Coding Style & Naming Conventions
Follow PSR-12 with 4-space indentation for PHP and 2-space indentation for JS/Blade. Run `./vendor/bin/pint` before committing to normalize formatting. Controllers, models, and jobs use `PascalCase`, config keys use `snake_case`, and Blade view files use kebab-case (for example, `inventory/index.blade.php`). Keep methods small, type-hint return values, and centralize validation in Form Requests under `app/Http/Requests`.

## Testing Guidelines
Pest is the default runner, but PHPUnit is available. Prefer arranging new tests under `tests/Feature` for HTTP flows and `tests/Unit` for pure logic; each describe block should read as behavior (`it_disables_overdue_loans`). Run `php artisan test` for the curated suite or `./vendor/bin/pest --coverage` when touching critical lending rules. Refresh the database within tests using `RefreshDatabase` and rely on factories located in `database/factories`.

## Commit & Pull Request Guidelines
Use Conventional Commit style (`feat: add instrument checkout policy`, `fix: prevent double reservation`). Keep the subject line under 72 characters and describe the rationale in the body when the change is non-trivial. Each PR should link the relevant issue, mention whether migrations or seeds are included, and attach UI screenshots for Blade changes. Re-run `composer test` and `npm run build` locally before requesting review to ensure the pipeline remains green.

## Security & Configuration Tips
Never commit `.env`; copy from `.env.example` and adjust database credentials, queue connection, and mail settings. Rotate `APP_KEY` via `php artisan key:generate --ansi` whenever credentials leak. Use `php artisan storage:link` to expose uploaded equipment documents under `storage/app/public`, and restrict queue workers to the `database` driver in development unless Redis is available.
