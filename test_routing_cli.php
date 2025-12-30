<?php

function test_route($method, $uri) {
    // Reset output buffer
    if (ob_get_level()) ob_end_clean();
    
    // Mock Server Vars
    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri;
    
    echo "Testing $method $uri ... ";
    
    ob_start();
    try {
        // We include index.php. Since index.php defines classes and functions, we need to be careful not to redeclare them if we include it multiple times.
        // However, `require` or `include` will execute the global code (routing) each time.
        // But spl_autoload_register will stack up if called multiple times.
        // AND classes cannot be redeclared.
        // So we can't easily include index.php multiple times in the same process if it defines classes or functions in the global scope (it doesn't, other than autoloader).
        // But the autoloader registration will duplicate.
        // A better approach for testing *this structure* where index.php is the entry point is to make index.php wrapper-friendly OR just run it via shell_exec for each test.
        // Let's use shell_exec for isolation.
        
        // This inside block is just for syntax check if I were running it here.
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    ob_end_clean();
}

$tests = [
    ['GET', '/home'],
    ['GET', '/users/101'],
    ['GET', '/post/50/comment/99'],
    ['GET', '/random-route-404'],
];

foreach ($tests as $test) {
    list($method, $uri) = $test;
    // We need to escape $ for both PHP string AND Shell.
    // PHP String: "\\\$_SERVER" -> Shell: "\$_SERVER" -> PHP CLI: "$_SERVER"
    $cmd = "php -r \"\\\$_SERVER['REQUEST_METHOD']='$method'; \\\$_SERVER['REQUEST_URI']='$uri'; require 'index.php';\"";
    echo "Request: $method $uri\n";
    $output = shell_exec($cmd);
    echo "Response:\n$output\n";
    echo "---------------------------\n";
}
