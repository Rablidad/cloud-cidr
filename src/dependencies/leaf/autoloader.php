<?php

spl_autoload_register(function ($class) {
    $file = str_replace('Leaf', '', $class);
    $file = __DIR__ . "\\$file.php";
    if (is_file($file)) {
        require $file;
    }
});