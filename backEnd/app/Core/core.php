<?php
require 'vendor/autoload.php';
if (!function_exists('handleCors')) {
    function handleCors() {
        $allowedOrigins = explode(',', getenv('ALLOWED_ORIGINS'));
        var_dump($_SERVER['HTTP_ORIGIN']);
        if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
            header("Access-Control-Allow-Origin: http://localhost:8081");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization, http://localhost:8080/index.php");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            if (in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
                header("HTTP/1.1 204 No Content");
                // exit();
            } else {
                header("HTTP/1.1 403 Forbidden");
                // exit();
            }
        }
    }
}