<style>
    .order-form-actions {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin: 10px 0 20px;
        gap: 10px;
        padding: 0 10px;
    }
    .order-form-button {
        flex: 1;
    }
    .order-form-button .btn {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }
    .save-btn { background-color: #28a745; color: white; }
    .delete-btn { background-color: #dc3545; color: white; bottom: 0;}

    .container { display: flex; gap: 40px; align-items: flex-start; }
    .menu-list, .selected-list { width: 50%; }
    .tile {
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 12px;
        background: #f9f9f9;
    }
    .tile img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    .btn-icon {
        font-size: 14px;
        width: 24px;
        height: 24px;
        border: none;
        background: #eee;
        border-radius: 4px;
        cursor: pointer;
        line-height: 1;
    }
    .count {
        font-weight: bold;
        margin-left: auto;
        font-size: 18px;
    }

    .user-select-row {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 10px;
    }

    .user-select-row .styled-select {
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 6px;
        border: 1px solid #ccc;
        background: #fff;
        height: 44px;
        width: 300px;
    }

    .client-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 10px 0;
        background-color: #f4f4f4;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 2px 2px 5px #ccc;
        max-width: 300px;
    }

    .client-preview img {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }

    .btn.new-btn {
        background: #eee;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        height: 44px;
        line-height: 1;
    }
</style>


<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../functions/order.php';
require_once __DIR__ . '/../functions/client.php';

$order_id = $_GET['id'] ?? 'new';

$menu = getMenu($pdo);
$selected_items = getSelectedItems($pdo, $order_id);
$users = get_all_users();

$user = null;
if ($order_id !== 'new') {
    $user = getUserByOrderId($pdo, $order_id);
}
?>

<div class="order-form-actions">
    <form method="post" action="/bubble_tea/components/post/update_order.php"
          onsubmit="return prepareSave()" class="order-form-button" id="order_form">
        <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
        <input type="hidden" name="items_json" id="items_json">

        <?php if ($order_id === 'new'): ?>
            <div class="user-select-row">
                <a href="/bubble_tea/admin.php?type=edit&section=client&id=new">
                    <button type="button" class="btn new-btn">Новий клієнт</button>
                </a>

                <select name="user_id" id="user_id" class="styled-select" onchange="updateClientPreview()" required>
                    <option value="">Оберіть клієнта</option>
                    <?php foreach ($users as $u): ?>
                        <option 
                            value="<?= $u['id'] ?>" 
                            data-name="<?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?>"
                            data-avatar="/bubble_tea/images/users/<?= htmlspecialchars($u['avatar']) ?>">
                            <?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="client-preview" class="client-preview" style="display: none;"></div>
        <?php endif; ?>

        <br>
        <button type="submit" name="action" value="save" class="btn save-btn">Зберегти</button>
    </form>

    <?php if ($order_id !== 'new'): ?>
        <form method="post" action="/bubble_tea/components/post/update_order.php"
              onsubmit="return confirm('Видалити замовлення?')" class="order-form-button">
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
            <button type="submit" name="action" value="delete" class="btn delete-btn">Видалити</button>
        </form>
    <?php endif; ?>
</div>

<?php if ($user): ?>
    <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
        <img src="/bubble_tea/images/users/<?= htmlspecialchars($user['avatar']) ?>"
             width="48" height="48" style="border-radius: 50%; object-fit: cover;">
        <div>
            <strong><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></strong><br>
            ID: <?= htmlspecialchars($user['id']) ?>
        </div>
    </div>
<?php endif; ?>

<div class="container">
    <div class="selected-list" id="selected">
        <h3>Обране</h3>
    </div>

    <div class="menu-list">
        <h3>Меню</h3>
        <?php foreach ($menu as $item): ?>
            <div class="tile" data-id="<?= $item['id'] ?>">
                <button class="btn-icon add">+</button>
                <div style="margin-left:auto; text-align: right;">
                    <div><?= htmlspecialchars($item['name']) ?></div>
                    <div><?= number_format($item['price'], 2) ?> грн</div>
                </div>
                <img src="/bubble_tea/images/menu/<?= htmlspecialchars($item['image']) ?>" alt="">
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function updateClientPreview() {
        const select = document.getElementById('user_id');
        const preview = document.getElementById('client-preview');
        const option = select.options[select.selectedIndex];

        const name = option.getAttribute('data-name');
        const avatar = option.getAttribute('data-avatar');

        if (!name || !avatar) {
            preview.style.display = 'none';
            preview.innerHTML = '';
            return;
        }

        preview.style.display = 'flex';
        preview.innerHTML = `
            <img src="${avatar}" alt="avatar">
            <div>${name}</div>
        `;
    }


    window.addEventListener('DOMContentLoaded', updateClientPreview);


    const selected = {};

    <?php foreach ($selected_items as $item): ?>
    selected[<?= $item['id'] ?>] = {
        name: <?= json_encode($item['name']) ?>,
        price: <?= json_encode($item['price']) ?>,
        image: <?= json_encode($item['image']) ?>,
        count: <?= $item['quantity'] ?>
    };
    <?php endforeach; ?>

    function renderSelected() {
        const container = document.getElementById('selected');
        container.innerHTML = '<h3>Обране</h3>';

        for (const [id, data] of Object.entries(selected)) {
            const tile = document.createElement('div');
            tile.className = 'tile';

            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn-icon';
            removeBtn.textContent = '-';
            removeBtn.onclick = () => {
                if (--selected[id].count <= 0) delete selected[id];
                renderSelected();
            };

            const img = document.createElement('img');
            img.src = `/bubble_tea/images/menu/${data.image}`;
            img.alt = '';

            const info = document.createElement('div');
            info.innerHTML = `<div>${data.name}</div><div>${data.price} грн</div>`;

            const count = document.createElement('div');
            count.className = 'count';
            count.textContent = `x${data.count}`;

            tile.appendChild(removeBtn);
            tile.appendChild(info);
            tile.appendChild(count);
            tile.appendChild(img);

            container.appendChild(tile);
        }
    }

    renderSelected();

    document.querySelectorAll('.tile .add').forEach(btn => {
        btn.addEventListener('click', e => {
            const tile = e.target.closest('.tile');
            const id = tile.dataset.id;
            const name = tile.querySelector('div:nth-child(2) > div:nth-child(1)').textContent;
            const price = tile.querySelector('div:nth-child(2) > div:nth-child(2)').textContent.split(' ')[0];
            const img = tile.querySelector('img').src.split('/').pop();

            if (!selected[id]) {
                selected[id] = { name, price, image: img, count: 1 };
            } else {
                selected[id].count++;
            }

            renderSelected();
        });
    });

    function prepareSave() {
        const items = [];
        for (const [id, data] of Object.entries(selected)) {
            items.push({ id, quantity: data.count });
        }
        document.getElementById('items_json').value = JSON.stringify(items);
        return true;
    }
</script>
