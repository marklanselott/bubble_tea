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

  .page-container {
      display: flex;
      gap: 40px;
      padding: 30px;
      flex-wrap: wrap;
  }

  .menu-item-edit-card {
      width: 350px;
      border-radius: 30px;
      background: #e0e0e0;
      box-shadow: 15px 15px 30px #bebebe, -15px -15px 30px #ffffff;
      display: flex;
      flex-direction: column;
  }

  .menu-item-edit-card-content {
      padding: 10px;
      box-sizing: border-box;
      flex: 1;
  }

  .menu-item-form-actions {
      display: flex;
      justify-content: space-between;
      margin-top: auto;
      margin-bottom: 10px;
      gap: 10px;
      padding: 0 10px;
  }

  .input-with-currency {
      position: relative;
      width: 100%;
  }

  .input-with-currency input {
      width: 100%;
      padding-right: 45px;
      box-sizing: border-box;
  }

  .currency-label {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      pointer-events: none;
      color: #555;
  }

  .file-drop-zone {
      border: 2px dashed #bbb;
      padding: 10px;
      text-align: center;
      cursor: pointer;
      margin-top: 10px;
      border-radius: 10px;
      background-color: #f9f9f9;
      transition: background-color 0.2s;
  }

  .file-drop-zone.dragover {
      background-color: #e0e0e0;
  }
</style>




<?php
require_once __DIR__ . '/../functions/menu_item.php';
require_once __DIR__ . '/../../config.php';

$id = $_GET['id'];
$is_new = ($id === 'new');
$menu_item = $is_new
    ? ['id' => 'new', 'name' => '', 'price' => 0, 'image' => $default_menu_image]
    : get_menu_item_by_id($id);
?>



<div class="page-container">

  <form action="/bubble_tea/components/post/update_menu_item.php" method="POST" enctype="multipart/form-data">
    <div class="menu-item-edit-card">
      <div class="menu-item-edit-card-content">
        <input type="hidden" name="id" value="<?= htmlspecialchars($menu_item['id']) ?>">

        <input class="tube-input" type="text" name="name" value="<?= htmlspecialchars($menu_item['name']) ?>" placeholder="Назва">

        <div class="input-with-currency">
          <input class="tube-input" type="number" name="price" step="0.01" min="0" value="<?= htmlspecialchars($menu_item['price']) ?>" placeholder="Ціна">
          <span class="currency-label">грн</span>
        </div>

        <div class="file-drop-zone" id="drop-zone">
          <p id="file-name-display"><?= htmlspecialchars($menu_item['image']) ?></p>
          <input type="file" id="file-input" name="image" hidden>
        </div>
      </div>

      <div class="menu-item-form-actions">
        <button type="submit" name="action" value="save" class="btn save-btn">Зберегти</button>
        <button type="submit" name="action" value="delete" class="btn delete-btn">Видалити</button>
      </div>
    </div>
  </form>

  <div style="max-width: 220px;">
    <div class="menu-card">
        <div class="image-wrapper">
          <img src="/bubble_tea/images/menu/<?= htmlspecialchars($menu_item['image']) ?>" alt="<?= htmlspecialchars($menu_item['name']) ?>">
        </div>
        <div class="name"><?= htmlspecialchars($menu_item['name']) ?></div>
        <div class="price"><?= htmlspecialchars($menu_item['price']) ?> грн</div>
    </div>
  </div>

</div>



<script>
  const dropZone = document.getElementById('drop-zone');
  const fileInput = document.getElementById('file-input');
  const dropText = document.getElementById('file-name-display');
  const previewImg = document.querySelector('.menu-card .image-wrapper img');
  const previewName = document.querySelector('.menu-card .name');
  const previewPrice = document.querySelector('.menu-card .price');

  const nameInput = document.querySelector('input[name="name"]');
  const priceInput = document.querySelector('input[name="price"]');


  function updatePreviewImage(file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      previewImg.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }


  nameInput.addEventListener('input', () => {
    previewName.textContent = nameInput.value.trim() || '—';
  });

  priceInput.addEventListener('input', () => {
    const value = parseFloat(priceInput.value);
    previewPrice.textContent = isNaN(value) ? '0.00 грн' : `${value.toFixed(2)} грн`;
  });


  dropZone.addEventListener('click', () => fileInput.click());

  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      fileInput.files = files;
      dropText.textContent = files[0].name;
      updatePreviewImage(files[0]);
    }
  });

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
      dropText.textContent = fileInput.files[0].name;
      updatePreviewImage(fileInput.files[0]);
    }
  });
</script>
