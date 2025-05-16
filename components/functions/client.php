<?php
require_once __DIR__ . '/../../db.php';


function get_user_by_id($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, first_name, last_name, avatar FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_all_users() {
    global $pdo;
    return $pdo->query("SELECT id, first_name, last_name, avatar FROM users")->fetchAll(PDO::FETCH_ASSOC);
}

function create_user($first_name, $last_name, $avatar = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, avatar) VALUES (?, ?, ?)");
    return $stmt->execute([$first_name, $last_name, $avatar]);
}


function delete_user($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}


function update_user($id, $first_name, $last_name, $avatar = null) {
    global $pdo;
    if ($avatar) {
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, avatar = ? WHERE id = ?");
        return $stmt->execute([$first_name, $last_name, $avatar, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE id = ?");
        return $stmt->execute([$first_name, $last_name, $id]);
    }
}


