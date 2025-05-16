<?php
require_once __DIR__ . '/../../config.php';

foreach ($sections as $title => $types) {
    $view = $types['type']['view'] ?? null;
    if ($view) {
        $query = http_build_query([
            'type' => 'view',
            'section' => $view['section']
        ]);
        echo "<li><a href='?{$query}'>{$title}</a></li>";
    }
}

?>