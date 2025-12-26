# MiniBlade Template Engine

A lightweight PHP template engine inspired by Laravel Blade, featuring inheritance, sections, and automated routing.

## Features

- **Template Inheritance**: Helper methods `@extend` and `@yield` (implemented as `$this->extend` and `$this->yield`).
- **Sections**: Define content blocks with `$this->section` and `$this->endSection`.
- **Clean URLs**: Automated routing support for pretty URLs (e.g., `/about` maps to `views/about.php`).
- **Zero Dependencies**: Pure PHP implementation.

## Directory Structure

```
/
├── src/
│   └── MiniBlade.php      # Core Engine Logic
├── views/
│   ├── layouts/
│   │   └── main.php       # Master Layout
│   ├── home.php           # Home View
│   └── about.php          # About View
├── index.php              # Front Controller & Router
└── .htaccess              # Apache Rewrite Rules
```

## Setup & Installation

1. Clone or copy this repository to your web server (e.g., `/var/www/html/demo`).
2. Ensure your web server (Apache) supports `.htaccess` and has `mod_rewrite` enabled.
3. Access the site via your browser (e.g., `http://demo.local/`).

## Usage

### Creating a Layout

Create a file in `views/layouts/` (e.g., `main.php`):

```php
<!DOCTYPE html>
<html>
<head>
    <title><?php $this->yield('title'); ?></title>
</head>
<body>
    <div class="container">
        <?php $this->yield('content'); ?>
    </div>
</body>
</html>
```

### Creating a Page

Create a file in `views/` (e.g., `contact.php`). It will be automatically accessible at `/contact`.

```php
<?php $this->extend('layouts/main'); ?>

<?php $this->section('title'); ?>
Contact Us
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
    <h1>Contact Page</h1>
    <p>Get in touch with us!</p>
<?php $this->endSection(); ?>
```

## Routing

The `index.php` file handles routing automatically. 
- URL `/foo` will look for `views/foo.php`.
- URL `/` will look for `views/home.php`.
- Returns 404 if the view file does not exist.
