<style>
  .order-status-edit-card {
      max-width: 300px;
      min-width: 150px;
      height: 150px;
      border-radius: 30px;
      background: #e0e0e0;
      box-shadow: 15px 15px 30px #bebebe, -15px -15px 30px #ffffff;
      display: flex;
      flex-direction: column;
  }

  .order-status-edit-card-content {
      padding: 10px;
      box-sizing: border-box;
      flex: 1;
  }

  .order-status-edit-avatar {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
  }

  .order-status-form-actions {
      display: flex;
      justify-content: space-between;
      margin-top: auto;
      margin-bottom: 10px;
      gap: 10px;
      padding: 0 10px;
  }
</style>



<?php
require_once __DIR__ . '/../functions/order_status.php';

$id = $_GET['id'];
$is_new = ($id === 'new');
$order_status = $is_new ? ['id' => 'new', 'name' => ''] : get_order_status_by_id($id);
?>

<form action="/bubble_tea/components/post/update_order_status.php" method="POST" enctype="multipart/form-data">
  <div class="order-status-edit-card">
    <div class="order-status-edit-card-content">
      <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
      <input class="tube-input" type="text" name="name" value="<?= htmlspecialchars($order_status['name']) ?>" placeholder="Назва">
    </div>
    <div class="order-status-form-actions">
      <button type="submit" name="action" value="save" class="btn save-btn">Зберегти</button>
      <button type="submit" name="action" value="delete" class="btn delete-btn">Видалити</button>
    </div>
  </div>
</form>


