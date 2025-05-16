<style>
  .user-edit-card {
      max-width: 400px;
      min-width: 150px;
      height: 370px;
      border-radius: 30px;
      background: #e0e0e0;
      box-shadow: 15px 15px 30px #bebebe, -15px -15px 30px #ffffff;
      display: flex;
      flex-direction: column;
  }

  .user-edit-card-content {
      padding: 10px;
      box-sizing: border-box;
      flex: 1;
  }

  .user-edit-avatar {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
  }

  .user-form-actions {
      display: flex;
      justify-content: space-between;
      margin-top: auto;
      margin-bottom: 10px;
      gap: 10px;
      padding: 0 10px;
  }
</style>






<?php
require_once __DIR__ . '/../functions/client.php';
require_once __DIR__ . '/../../config.php';

$id = $_GET['id'];
$is_new = ($id === 'new');
$user = $is_new ? ['id' => 'new', 'first_name' => '', 'last_name' => '', 'avatar' => $default_user_avatar] : get_user_by_id($id);
?>

<form action="/bubble_tea/components/post/update_client.php" method="POST" enctype="multipart/form-data">
  <div class="user-edit-card">
    <div class="user-edit-card-content">
      <div class="user-info-row">
        <img class="user-edit-avatar" src="/bubble_tea/images/users/<?= $user['avatar'] ?>" alt="avatar">
      </div>

      <input type="hidden" name="id" value="<?= $user['id'] ?>">

      <input class="tube-input" type="text" name="first_name" value="<?= $user['first_name'] ?>" placeholder="Ім'я">
      <input class="tube-input" type="text" name="last_name" value="<?= $user['last_name'] ?>" placeholder="Прізвище">

      <div class="file-drop-zone" id="drop-zone">
        <p id="file-name-display"><?= $user['avatar'] ?></p>
        <input type="file" id="file-input" name="avatar" hidden>
      </div>
    </div>
    <div class="user-form-actions">
      <button type="submit" name="action" value="save" class="btn save-btn">Зберегти</button>

      <?php if (!$is_new): ?>
          <button type="submit" name="action" value="delete" class="btn delete-btn" onclick="return confirm('Видалити клієнта?')">Видалити</button>
      <?php endif; ?>
  </div>
  </div>
</form>



<script>
  const dropZone = document.getElementById('drop-zone');
  const fileInput = document.getElementById('file-input');
  const dropText = document.getElementById('file-name-display');

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
    }
  });

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
      dropText.textContent = fileInput.files[0].name;
    }
  });
</script>