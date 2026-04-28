<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" behavior from the
// command line. A request to "/index.php/some/path" gets translated into
// "/index.php?some/path" which then routes to the Laravel application.

if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false; // serve the requested resource as-is
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__.'/public/index.php';

try {
    require __DIR__.'/public/index.php';
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    throw $e;
}