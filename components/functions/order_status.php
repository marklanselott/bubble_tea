<?php
require_once __DIR__ . '/../../db.php';

function get_order_status_by_id($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM order_statuses WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function delete_order_status($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM order_statuses WHERE id = ?");
    $stmt->execute([$id]);
}

function insert_order_status($pdo, $name) {
    $stmt = $pdo->prepare("INSERT INTO order_statuses (name) VALUES (?)");
    $stmt->execute([$name]);
}

function update_order_status($pdo, $id, $name) {
    $stmt = $pdo->prepare("UPDATE order_statuses SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);
}
?>
