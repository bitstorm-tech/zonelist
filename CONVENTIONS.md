# ZoneList Development Guide

## Key Commands
- **Development:** `php artisan serve` (web server), `npm run dev` (frontend)
- **All-in-one:** `php artisan solo` (starts all required services)
- **Testing:** `./vendor/bin/pest` or `php artisan test`
- **Test Single File:** `./vendor/bin/pest tests/path/to/test.php`
- **Migrations:** `php artisan migrate` (fresh: `--fresh`, rollback: `:rollback`)
- **Create Components:** `php artisan make:livewire ComponentName`
- **Laravel Tinker:** `php artisan tinker` (interactive REPL)

## Code Style
- Use Laravel version 12 or higher
- Use strong typing with type annotations everywhere
- Follow Laravel/PHP PSR-12 coding standards
- Use Livewire for reactive components
- Use Alpine.js for client-side interactivity
- Use Tailwind CSS with daisyUI for styling
- Use artisan commands where possible
- Organize components by feature when practical
- Use return type declarations for methods
- Use dependency injection via constructor
- Write descriptive variable and method names

