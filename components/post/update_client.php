<?php
require_once __DIR__ . '/../functions/client.php';
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../config.php';

$id = $_POST['id'] ?? null;
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$avatar_name = null;

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
    if ($id !== 'new') {
        $user = get_user_by_id($id);
        $old_avatar = $user['avatar'] ?? null;
    }

    $upload_dir = __DIR__ . '/../../images/' . $users_folder . '/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $avatar_name = 'photo_' . date('Y-m-d_H-i-s') . '.' . $ext;
    move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_dir . $avatar_name);

    if (!empty($old_avatar) && $old_avatar !== $default_user_avatar && $old_avatar !== $avatar_name) {
        $old_path = $upload_dir . $old_avatar;
        if (file_exists($old_path)) unlink($old_path);
    }
}

if (!$avatar_name && $id !== 'new') {
    $user = get_user_by_id($id);
    $avatar_name = $user['avatar'] ?? $default_user_avatar;
}

if ($_POST['action'] === 'delete' && $id !== 'new') {
    delete_user($id);
} elseif ($id === 'new') {
    create_user($first_name, $last_name, $avatar_name ?? $default_user_avatar);
} else {
    update_user($id, $first_name, $last_name, $avatar_name);
}

header("Location: /bubble_tea/admin.php?type=view&section=client_list");
exit;
