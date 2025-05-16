<?php

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

function getMenu(PDO $pdo) {
    $stmt = $pdo->query("SELECT id, name, price, image FROM menu");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllOrders(PDO $pdo) {
    $sql = "
        SELECT 
            orders.id AS order_id,
            order_statuses.name AS status_name,
            users.first_name,
            users.last_name,
            users.id AS user_id,
            users.avatar,
            menu.name AS menu_name,
            menu.price,
            order_items.quantity
        FROM orders
        JOIN users ON orders.user_id = users.id
        JOIN order_statuses ON orders.status_id = order_statuses.id
        JOIN order_items ON orders.id = order_items.order_id
        JOIN menu ON order_items.menu_item_id = menu.id
        ORDER BY orders.time_start DESC
    ";

    $stmt = $pdo->query($sql);
    $raw = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $orders = [];
    foreach ($raw as $row) {
        $id = $row['order_id'];
        if (!isset($orders[$id])) {
            $orders[$id] = [
                'user_id' => $row['user_id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'avatar' => $row['avatar'],
                'status_name' => $row['status_name'],
                'items' => []
            ];
        }
        $orders[$id]['items'][] = [
            'menu_name' => $row['menu_name'],
            'price' => $row['price'],
            'quantity' => $row['quantity']
        ];
    }

    return $orders;
}

function deleteOrder(PDO $pdo, $order_id) {
    $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$order_id]);
    $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$order_id]);
}

function saveOrder(PDO $pdo, $order_id, $user_id, $items_json) {
    $items = json_decode($items_json, true);

    if ($order_id === 'new') {

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, status_id) VALUES (?, ?)");
        $stmt->execute([$user_id, 1]);
        $order_id = $pdo->lastInsertId();
    } else {
        $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$order_id]);
    }

    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity) VALUES (?, ?, ?)");
    foreach ($items as $item) {
        $stmt->execute([$order_id, $item['id'], $item['quantity']]);
    }

    return $order_id;
}

function getUserByOrderId(PDO $pdo, $order_id) {
    $stmt = $pdo->prepare("SELECT users.* FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = ?");
    $stmt->execute([$order_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>