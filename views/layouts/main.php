<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $this->yield('title', 'Default Title'); ?></title>
    <style>
        body { font-family: sans-serif; padding: 2rem; }
        header, footer { background: #eee; padding: 1rem; margin-bottom: 2rem; }
        footer { margin-top: 2rem; }
    </style>
</head>
<body>
    <header>
        <h1>My Website</h1>
    </header>

    <div class="container">
        <?php $this->yield('content'); ?>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> My Website</p>
    </footer>
</body>
</html>
