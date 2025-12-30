# MiniFrame (MiniBlade + Custom Router)

A lightweight PHP micro-framework featuring a Laravel-like Router and the MiniBlade template engine.

## Features

- **Custom Router**: Define routes with `Router::get`, `Router::post`, etc.
- **Controller Support**: Route requests to controller classes and methods.
- **Dynamic Parameters**: Support for `{id}` style parameters in URLs.
- **Template Inheritance**: MiniBlade engine with `@extend` and `@yield` syntax.
- **Zero Dependencies**: Pure PHP implementation.

## Directory Structure

```
/
├── src/
│   ├── MiniBlade.php      # Template Engine
│   ├── Router.php         # Routing Logic
│   └── Controllers/       # Controller Classes
│       └── UserController.php
├── views/
│   ├── layouts/
│   │   └── main.php       # Master Layout
│   ├── home.php           # Home View
│   └── about.php          # About View
├── index.php              # Front Controller & Route Definitions
└── .htaccess              # Apache Rewrite Rules
```

## Setup & Installation

1. Clone or copy this repository to your web server (e.g., `/var/www/html/demo`).
2. Ensure your web server (Apache) supports `.htaccess` and has `mod_rewrite` enabled.
3. Access the site via your browser (e.g., `http://localhost/demo/`).

## Usage

### Defining Routes

Routes are defined in `index.php` using the `Router` class.

```php
use App\Router;
use App\Controllers\UserController;

// Closure Route
Router::get('/home', function() {
    echo "Welcome Home";
});

// Controller Route
Router::get('/users/{id}', [UserController::class, 'show']);

// POST Route
Router::post('/submit', [UserController::class, 'store']);
```

### Creating Controllers

Create a controller in `src/Controllers/`:

```php
namespace App\Controllers;

class UserController
{
    public function show($id)
    {
        echo "User Profile for ID: $id";
    }
}
```

### Templating (MiniBlade)

Views are stored in `views/`. Use `$blade->render()` in your routes/controllers.

**Layout (`views/layouts/main.php`):**
```php
<!DOCTYPE html>
<html>
<body>
    <?php $this->yield('content'); ?>
</body>
</html>
```

**Page (`views/home.php`):**
```php
<?php $this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
    <h1>Home Page</h1>
<?php $this->endSection(); ?>
```
