# Testing Standards

## Pest PHP
- Use Pest for all tests.
- Create tests using `php artisan make:test --pest`.

## Database Isolation
- **NEVER** run tests against the main database in `.env`.
- Tests must use a separate SQLite database (usually `:memory:`).
- Every change must be verified with a passing test before finalization.

## Performance
- Run specific tests using `php artisan test --filter=...` or `--compact` to save time.
