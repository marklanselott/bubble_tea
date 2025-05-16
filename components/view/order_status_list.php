<style>
.order_status-row-card {
    display: block;
    padding: 16px 20px;
    margin-bottom: 10px;
    background-color: #f4f4f4;
    border-radius: 12px;
    box-shadow: 4px 4px 8px #ccc, -4px -4px 8px #fff;
    text-decoration: none;
    color: #222;
    font-size: 18px;
    font-weight: 500;
    transition: background-color 0.2s, box-shadow 0.2s;
}

.order_status-row-card:hover {
    background-color: #eaeaea;
    box-shadow: inset 2px 2px 6px #ccc, inset -2px -2px 6px #fff;
}

.order_status-name {
    pointer-events: none;
}
</style>



<div class="user-form-actions">
    <a href="/bubble_tea/admin.php?type=edit&section=order_status&id=new">
        <button type="submit" name="action" value="new" class="btn new-btn">Новий статус</button>
    </a>
</div>
<br>

<?php
require_once __DIR__ . '/../../db.php';

$stmt = $pdo->query("SELECT id, name FROM order_statuses");
$statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($statuses as $status): ?>
    <a href="/bubble_tea/admin.php?type=edit&section=order_status&id=<?= $status['id'] ?>" class="order_status-row-card">
        <div class="order_status-name"><?= htmlspecialchars($status['name']) ?></div>
    </a>
<?php endforeach; ?>
