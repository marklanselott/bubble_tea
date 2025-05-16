<?php
require_once __DIR__ . '/../functions/menu_item.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../db.php';

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? '';
$price = $_POST['price'] ?? 0;
$image_name = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    if ($id !== 'new') {
        $menu_item = get_menu_item_by_id($id);
        $old_image = $menu_item['image'] ?? null;
    }

    $upload_dir = __DIR__ . '/../../images/menu/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $image_name = 'menu_' . date('Y-m-d_H-i-s') . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);

    if (!empty($old_image) && $old_image !== $default_menu_image && $old_image !== $image_name) {
        $old_path = $upload_dir . $old_image;
        if (file_exists($old_path)) unlink($old_path);
    }
}

if (!$image_name && $id !== 'new') {
    $menu_item = get_menu_item_by_id($id);
    $image_name = $menu_item['image'] ?? $default_menu_image;
}

if ($_POST['action'] === 'delete' && $id !== 'new') {
    delete_menu_item($id);
} elseif ($id === 'new') {
    create_menu_item($name, $price, $image_name ?? $default_menu_image);
} else {
    update_menu_item($id, $name, $price, $image_name);
}

header("Location: /bubble_tea/admin.php?type=view&section=menu_list");
exit;
