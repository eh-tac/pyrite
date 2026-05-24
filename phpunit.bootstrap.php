<?php
spl_autoload_register(function ($class) {
    if (strpos($class, 'Pyrite\\') !== 0) {
        return;
    }

    $relative = substr($class, 7);
    $path = __DIR__ . '/lib/' . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($path)) {
        require $path;
    }
});
