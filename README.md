# ClientFlow SaaS

ClientFlow is a multi-tenant SaaS application designed for freelancing agencies to manage clients, billing, projects, and tasks.

## Project Overview

- **Framework:** Laravel 13
- **PHP:** 8.4
- **Frontend:** Livewire 3 + Volt 1 + Tailwind CSS v4
- **Testing:** Pest PHP 4
- **Database:** PostgreSQL (Production) / SQLite (Testing)
- **Primary Keys:** UUIDs across all models

---

## Source of Truth & Documentation

This project follows a strict "Hub-and-Spoke" documentation model. For detailed rules and technical requirements, refer to the following guides:

### 1. [Database & Models Guide](docs/database.md)
- UUID Primary Keys (`HasUuids`).
- **CRITICAL:** NEVER use `->constrained()` for UUID foreign keys. Use `->index()`.
- PostgreSQL compatibility mandate.
- ER Diagram details.

### 2. [Multi-Tenancy & Isolation Guide](docs/multi-tenancy.md)
- `Tenantable` trait for `workspace_id` scoping.
- `ClientScoped` trait for external client record isolation.
- Role-based access (owner, admin, member, client).

### 3. [UI/UX & Styling Guide](docs/ui-ux.md)
- Tailwind CSS v4 patterns.
- Design Tokens (NO hardcoded styles).
- FluxUI and Shadcn-inspired Blade components.
- Modern Layouts (`{{ $slot }}`).

### 4. [Testing Standards Guide](docs/testing.md)
- Pest PHP for all tests.
- Mandatory separate SQLite database for testing.
- No changes without verification tests.

### 5. [Security & Authorization Guide](docs/security.md)
- Role-Based Access Control (RBAC).
- `owner`, `admin`, `member`, `client` roles.
- Mandatory Policy classes for each model.
- Double-layer protection: Scopes + Policies.

---

## Technical Foundations

### Multi-Tenancy
Every tenant-owned record belongs to a `Workspace`. We use the `Tenantable` trait to automatically scope queries and assign `workspace_id` on creation.

### Client Access
Clients can log in to view their specific projects and invoices. This is handled via the `ClientScoped` trait, which further restricts access even within a workspace.

### Coding Standards
- Strictly follow SOLID principles.
- Use Service or Action classes for complex logic only.
- Follow Laravel 13 coding patterns.
- Always run `vendor/bin/pint` before committing PHP changes.

---

## Getting Started

1. Clone the repository.
2. Copy `.env.example` to `.env`.
3. Run `composer install` and `npm install`.
4. Run `php artisan migrate --seed` (Uses `TestUserSeeder` for default login).
5. Default login: `test@example.com` / `password`.
