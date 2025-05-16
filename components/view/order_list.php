<style>
    .order {
        display: flex;
        align-items: flex-start;
        margin: 20px 0;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #f9f9f9;
    }

    .order-left {
        width: 15%;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .order-left img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
    }

    .order-left .name {
        font-weight: bold;
        font-size: 1em;
    }

    .order-left .info {
        color: #333;
        font-size: 0.85em;
    }

    .order-right {
        width: 83%;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-left: auto;
    }

    .menu-card {
        flex: 1 1 30%;
        background: white;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .menu-inner {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .menu-qty {
        font-weight: bold;
        font-size: 1em;
        color: #000;
        white-space: nowrap;
    }

    .menu-content h4 {
        margin: 0 0 4px;
        font-size: 0.95em;
        font-weight: bold;
    }

    .menu-content p {
        margin: 0;
        font-size: 0.85em;
        color: #555;
    }

    .order-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
</style>

<div class="menu-form-actions">
    <a href="/bubble_tea/admin.php?type=edit&section=order&id=new">
        <button type="submit" name="action" value="new" class="btn new-btn">Нова замовлення</button>
    </a>
</div>
<br>

<?php
require_once __DIR__ . '/../functions/order.php';
require_once __DIR__ . '/../../db.php';

$orders = getAllOrders($pdo);



foreach ($orders as $order_id => $order): ?>
<a href="/bubble_tea/admin.php?type=edit&section=order&id=<?= $order_id ?>" class="order-link">
    <div class="order">
        <div class="order-left">
            <img src="/bubble_tea/images/users/<?= htmlspecialchars($order['avatar']) ?>" alt="avatar">
            <div class="name"><?= htmlspecialchars($order['first_name']) ?> <?= htmlspecialchars($order['last_name']) ?></div>
            <div class="info">ID: <?= $order_id ?></div>
            <div class="info">Статус: <?= htmlspecialchars($order['status_name']) ?></div>
        </div>
        <div class="order-right">
            <?php foreach ($order['items'] as $item): ?>
            <div class="menu-card">
                <div class="menu-inner">
                    <div class="menu-qty">x<?= $item['quantity'] ?></div>
                    <div class="menu-content">
                        <h4><?= htmlspecialchars($item['menu_name']) ?></h4>
                        <p>Ціна: <?= $item['price'] ?> грн</p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</a>
<?php endforeach; ?>
