<?php

require_once __DIR__ . '/config.php';

$pdo = new PDO("{$db_type}:host={$db_host};dbname={$db_name};charset=utf8", $db_username, "");

?>