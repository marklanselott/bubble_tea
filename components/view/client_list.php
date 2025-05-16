<style>
    .client-row-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        margin-bottom: 8px;
        background-color: #f4f4f4;
        border-radius: 10px;
        box-shadow: 3px 3px 6px #ccc, -3px -3px 6px #fff;
        text-decoration: none;
        color: #222;
        font-size: 16px;
        font-weight: 500;
        transition: background-color 0.2s, box-shadow 0.2s;
    }

    .client-row-card:hover {
        background-color: #eaeaea;
        box-shadow: inset 2px 2px 5px #ccc, inset -2px -2px 5px #fff;
    }

    .client-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<div class="user-form-actions">
    <a href="/bubble_tea/admin.php?type=edit&section=client&id=new">
        <button type="submit" name="action" value="new" class="btn new-btn">Новий клієнт</button>
    </a>
</div>
<br>

<?php
require_once __DIR__ . '/../functions/client.php';
require_once __DIR__ . '/../../config.php';
$users = get_all_users();
?>

<?php foreach ($users as $user): ?>
    <a class="client-row-card" href="/bubble_tea/admin.php?type=edit&section=client&id=<?= $user['id'] ?>">
        <img class="client-avatar" src="/bubble_tea/images/<?= $users_folder . '/' . $user['avatar'] ?>" alt="avatar">

        <?= $user['first_name'] . ' ' . $user['last_name'] ?>
    </a>
<?php endforeach; ?>
