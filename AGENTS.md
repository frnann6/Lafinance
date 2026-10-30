# AGENTS.md — Lafinance

## Stack

- PHP `^8.2`, CodeIgniter 4 `^4.7`, CodeIgniter Shield `^1.4`, MySQLi.
- Personal finance app (UI berbahasa Indonesia) di branch `main`.

## Commands

- Dev server: `php spark serve` — butuh baseURL `http://localhost:8080/` (`app/Config/App.php`).
- DB migrations: `php spark migrate` — hanya ada 2 migrasi di `app/Database/Migrations/` (`CreateTransactionsTable`, `CreateUserProfiles`); tabel Shield diasumsikan dari migrasi bawaan Shield di `vendor/`.
- Tests: `composer test` (`phpunit`). Baru ada test default CI4 (`tests/HealthTest.php`, `Example*`) — belum ada test aplikasi. Database tests pakai SQLite `:memory:` (`app/Config/Database.php`).

## Architecture notes

- Flat structure, tanpa modul HMVC — semua di folder `app/` standar (Controllers, Models, Config, Views).
- Shield di-override via file di `app/Config/` (`Auth.php`, `AuthGroups.php`, `AuthToken.php`) dan controller/view kustom di `app/Controllers/Auth/`, `app/Views/Shield/`.
- Auth: Shield session authenticator (chain: session, tokens, hmac). Login via **email saja** (`validFields`). Magic link login aktif (lifetime 1 jam). Registrasi pakai controller custom `Auth\RegisterController` yang **logout setelah register** (wajib login manual setelah registrasi).
- Guard: Shield `SessionAuth` via alias `session` di `app/Config/Filters.php`; route dashboard wajib pakai filter `['filter' => 'session']`.

## Gotchas

- CSRF filter **disabled** (`app/Config/Filters.php` — baris di komentar), padahal form sudah menyertakan `csrf_field()`.
- `app/Views/transactions/create.php` **semuanya sedang dikomentai** — tampilan create transaksi tidak aktif.
- Dashboard controller memiliki query yang berpotensi tersebar/duplicate (transaksiTerbaru vs transactions) dengan limit berbeda.
- SMTP credentials (Gmail) hardcoded di `app/Config/Email.php`.

## Conventions

- Flash message lewat redirect: `->with('error' | 'message' | 'errors', ...)`.
- Model CI4: definisi table/PK/allowedFields/useTimestamps/validationRules/validationMessages.
- Query user-scoped: `where('user_id', auth()->user()->id)`.

## Environment

- Copy `env` → `.env` (gitignored). DB MySQLi group `default` (`lafinance`, user `admin`). `CI_ENVIRONMENT = development`.

## Gaya Komunikasi 
- Selalu gunakan minimal satu emoji yang relevan di setiap balasan, karena saya suka emoji.
- Gunakan emoji secukupnya agar balasan tetap profesional dan tidak berlebihan.