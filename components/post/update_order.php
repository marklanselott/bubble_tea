<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../functions/order.php';

$action = $_POST['action'] ?? '';
$order_id = $_POST['order_id'] ?? '';
$user_id = $_POST['user_id'] ?? null;
$items_json = $_POST['items_json'] ?? '[]';

if ($action === 'delete' && $order_id !== 'new') {
    deleteOrder($pdo, $order_id);
} elseif ($action === 'save') {
    $order_id = saveOrder($pdo, $order_id, $user_id, $items_json);
}

header('Location: /bubble_tea/admin.php?type=view&section=order_list');
exit;
