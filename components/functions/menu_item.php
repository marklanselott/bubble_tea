<?php
require_once __DIR__ . '/../../db.php';

function get_menu_item_by_id($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_all_menu_items() {
    global $pdo;
    return $pdo->query("SELECT * FROM menu")->fetchAll(PDO::FETCH_ASSOC);
}

function create_menu_item($name, $price, $image) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO menu (name, price, image) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $price, $image]);
}

function update_menu_item($id, $name, $price, $image) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE menu SET name = ?, price = ?, image = ? WHERE id = ?");
    return $stmt->execute([$name, $price, $image, $id]);
}

function delete_menu_item($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM menu WHERE id = ?");
    return $stmt->execute([$id]);
}
function getMenu(PDO $pdo) {
    $stmt = $pdo->query("SELECT id, name, price, image FROM menu");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSelectedItems(PDO $pdo, $order_id) {
    if ($order_id === 'new') return [];

    $stmt = $pdo->prepare("
        SELECT menu.id, menu.name, menu.price, menu.image, order_items.quantity
        FROM order_items
        JOIN menu ON order_items.menu_item_id = menu.id
        WHERE order_items.order_id = ?
    ");
    $stmt->execute([$order_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}