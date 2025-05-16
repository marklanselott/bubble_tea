<style>
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .menu-card {
        background: #e0e0e0;
        border-radius: 20px;
        padding: 15px;
        box-shadow: 10px 10px 20px #bebebe, -10px -10px 20px #ffffff;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: inherit;
    }

    .image-wrapper {
        width: 100%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        border-radius: 15px;
        background-color: #f9f9f9;
        margin-bottom: 10px;
    }

    .menu-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .menu-card .name {
        font-weight: bold;
        font-size: 16px;
        margin: 0 0 5px 0;
        text-align: center;
    }

    .menu-card .price {
        color: #333;
        font-size: 14px;
        margin: 0;
    }

    .menu-form-actions {
        padding-left: 20px;
    }
</style>

<div class="menu-form-actions">
    <a href="/bubble_tea/admin.php?type=edit&section=menu_item&id=new">
        <button type="submit" name="action" value="new" class="btn new-btn">Нова позиція</button>
    </a>
</div>

<?php
require_once __DIR__ . '/../functions/menu_item.php';
require_once __DIR__ . '/../../config.php';
$menu_items = get_all_menu_items();
?>

<div class="menu-grid">
<?php foreach ($menu_items as $item): ?>
    <a href="/bubble_tea/admin.php?type=edit&section=menu_item&id=<?= (int)$item['id'] ?>" class="menu-card">
        <div class="image-wrapper">
            <img src="/bubble_tea/images/<?= htmlspecialchars($menu_folder) . "/" . htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        </div>
        <div class="name"><?= htmlspecialchars($item['name']) ?></div>
        <div class="price"><?= htmlspecialchars($item['price']) ?> грн</div>
    </a>
<?php endforeach; ?>
</div>
