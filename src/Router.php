<?php

namespace App;

/**
 * Class Router
 * simple router
 */
class Router
{
    private static array $routes = [];

    /**
     * Add a GET route
     *
     * @param string $path
     * @param callable|array $handler
     * @return void
     */
    public static function get(string $path, $handler): void
    {
        self::addRoute('GET', $path, $handler);
    }

    /**
     * Add a POST route
     *
     * @param string $path
     * @param callable|array $handler
     * @return void
     */
    public static function post(string $path, $handler): void
    {
        self::addRoute('POST', $path, $handler);
    }

    /**
     * Add a PUT route
     *
     * @param string $path
     * @param callable|array $handler
     * @return void
     */
    public static function put(string $path, $handler): void
    {
        self::addRoute('PUT', $path, $handler);
    }

    /**
     * Add a DELETE route
     *
     * @param string $path
     * @param callable|array $handler
     * @return void
     */
    public static function delete(string $path, $handler): void
    {
        self::addRoute('DELETE', $path, $handler);
    }

    /**
     * Register route internally
     *
     * @param string $method
     * @param string $path
     * @param callable|array $handler
     * @return void
     */
    private static function addRoute(string $method, string $path, $handler): void
    {
        // Convert route path to regex
        // Escape forward slashes
        // Convert {param} to named capture groups (?P<param>[^/]+)
        
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        
        // Add start and end delimiters
        $pattern = "#^" . $pattern . "$#";

        self::$routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    /**
     * Dispatch the request
     *
     * @return mixed
     */
    public static function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Remove trailing slash if not root, generic normalization
        if (strlen($uri) > 1) {
            $uri = rtrim($uri, '/');
        }
        
        $method = $_SERVER['REQUEST_METHOD'];

        // Handle POST _method override for PUT/DELETE
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        foreach (self::$routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $uri, $matches)) {
                // Filter out numeric keys from matches (keep only named parameters)
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $handler = $route['handler'];

                if (is_array($handler)) {
                    $controller = new $handler[0]();
                    $action = $handler[1];
                    
                    // Note: We are using call_user_func_array to unpack matches into method arguments
                    return call_user_func_array([$controller, $action], $params);
                } else if (is_callable($handler)) {
                    return call_user_func_array($handler, $params);
                }
            }
        }

        // 404
        http_response_code(404);
        echo "404 Not Found";
    }
}
