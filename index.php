<?php

require_once 'src/MiniBlade.php';

$blade = new MiniBlade(__DIR__ . '/views');

$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);
$path = trim($path, '/');

// Default to home if path is empty
$view = empty($path) ? 'home' : $path;

// Basic safety check
$view = basename($view);

// Handle 404 if view doesn't exist
if (!file_exists(__DIR__ . "/views/$view.php")) {
    http_response_code(404);
    echo "404 - View '$view' not found";
    exit;
}

echo $blade->render($view, [
    'message' => 'Hello from MiniBlade!'
]);