<?php
// Mock server environment for CLI testing
function test_route($uri) {
    $_SERVER['REQUEST_URI'] = $uri;
    
    // Capture output
    ob_start();
    include 'index.php';
    $output = ob_get_clean();
    
    echo "URI: $uri\n";
    echo "Status: " . (strpos($output, '404 - View') !== false ? '404 Not Found' : '200 OK') . "\n";
    if (strpos($output, '<title>') !== false) {
        preg_match('/<title>(.*?)<\/title>/s', $output, $matches);
        echo "Title: " . trim($matches[1] ?? 'Unknown') . "\n";
    } else {
        echo "Valid Title NOT Found. Full Output:\n" . $output . "\n";
    }
    echo "--------------------------\n";
}

echo "Running Routing Tests...\n--------------------------\n";
test_route('/');
test_route('/about');
test_route('/contact'); // Should be 404
