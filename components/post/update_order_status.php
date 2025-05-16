<?php
require_once __DIR__ . '/../functions/order_status.php';
require_once __DIR__ . '/../../db.php';

$id   = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');

if ($_POST['action'] === 'delete' && $id !== 'new') {
    $stmt = $pdo->prepare("DELETE FROM order_statuses WHERE id = ?");
    $stmt->execute([$id]);
} else {
    if ($id === 'new') {
        $stmt = $pdo->prepare("INSERT INTO order_statuses (name) VALUES (?)");
        $stmt->execute([$name]);
    } else {
        $stmt = $pdo->prepare("UPDATE order_statuses SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
    }
}

header('Location: /bubble_tea/admin.php?type=view&section=order_status_list');
exit;

