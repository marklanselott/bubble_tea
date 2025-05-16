<?php
require_once __DIR__ . '/config.php';

$type = $_GET['type'] ?? null;
$section = $_GET['section'] ?? null;

if ($section && $type) {
    $file = __DIR__ . "{$folder_components}/{$type}/{$section}.php";
    if (file_exists($file)) {
        require_once $file;
    } else {
        require_once __DIR__ . $not_found;
    }
}
