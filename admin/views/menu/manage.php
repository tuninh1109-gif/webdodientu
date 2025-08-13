<?php
require_once __DIR__ . '/../../../config/db.php';
$type = isset($_GET['type']) && $_GET['type'] === 'admin' ? 'admin' : 'user';

// Xử lý thêm/sửa/xóa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $label = mysqli_real_escape_string($conn, $_POST['label']);
        $url = mysqli_real_escape_string($conn, $_POST['url']);
        $icon = mysqli_real_escape_string($conn, $_POST['icon']);
        $position = (int)$_POST['position'];
        $sql = "INSERT INTO menu_content (label, url, icon, position, type) VALUES ('$label', '$url', '$icon', $position, '$type')";
        mysqli_query($conn, $sql);
    } elseif (isset($_POST['edit_id'])) {
        $id = (int)$_POST['edit_id'];
        $label = mysqli_real_escape_string($conn, $_POST['label']);
        $url = mysqli_real_escape_string($conn, $_POST['url']);
        $icon = mysqli_real_escape_string($conn, $_POST['icon']);
        $position = (int)$_POST['position'];
        $sql = "UPDATE menu_content SET label='$label', url='$url', icon='$icon', position=$position WHERE id=$id";
        mysqli_query($conn, $sql);
        // Chuyển hướng về URL không có edit để form trở về trạng thái thêm mới
        header('Location: index.php?page=menu&type=' . $type);
        exit;
    } elseif (isset($_POST['delete_id'])) {
        $id = (int)$_POST['delete_id'];
        $sql = "DELETE FROM menu_content WHERE id=$id";
        mysqli_query($conn, $sql);
    }
}
// Lấy danh sách menu
$sql = "SELECT * FROM menu_content WHERE type='$type' ORDER BY position ASC, id ASC";
$res = mysqli_query($conn, $sql);
$menus = [];
while ($row = mysqli_fetch_assoc($res)) $menus[] = $row;
// Nếu sửa
$edit_menu = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    foreach ($menus as $m) if ($m['id'] == $id) $edit_menu = $m;
}
?>
<div class="container mt-4">
  <h3>Quản lý Menu <?php echo $type === 'admin' ? 'Admin' : 'User'; ?></h3>
  <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<form method="post" class="row g-2 align-items-end mb-4 shadow-sm p-3 bg-white rounded">
  <input type="hidden" name="edit_id" value="<?php echo $edit_menu['id'] ?? ''; ?>">
  <div class="col-md-3">
    <label class="form-label fw-semibold">Tên menu</label>
    <input type="text" name="label" class="form-control" value="<?php echo $edit_menu['label'] ?? ''; ?>" required>
  </div>
  <div class="col-md-3">
    <label class="form-label fw-semibold">Đường dẫn</label>
    <input type="text" name="url" class="form-control" value="<?php echo $edit_menu['url'] ?? ''; ?>" required>
  </div>
  <div class="col-md-2">
    <label class="form-label fw-semibold">Icon (Bootstrap)</label>
    <input type="text" name="icon" class="form-control" value="<?php echo $edit_menu['icon'] ?? ''; ?>" placeholder="bi-house">
    <div class="form-text">VD: bi-house, bi-cart</div>
  </div>
  <div class="col-md-2">
    <label class="form-label fw-semibold">Vị trí</label>
    <input type="number" name="position" class="form-control" value="<?php echo $edit_menu['position'] ?? '0'; ?>">
  </div>
  <div class="col-md-2 d-flex gap-2 align-items-end">
    <button type="submit" name="<?php echo $edit_menu ? 'edit' : 'add'; ?>" class="btn btn-<?php echo $edit_menu ? 'warning' : 'primary'; ?> fw-bold px-3">
      <?php echo $edit_menu ? 'Cập nhật' : 'Thêm mới'; ?>
    </button>
    <?php if ($edit_menu): ?>
      <a href="?type=<?php echo $type; ?>" class="btn btn-secondary">Huỷ</a>
    <?php endif; ?>
    <a href="index.php?page=menu&type=<?php echo $type === 'admin' ? 'user' : 'admin'; ?>" class="btn btn-outline-dark ms-2">Quản lý menu <?php echo $type === 'admin' ? 'User' : 'Admin'; ?></a>
  </div>
</form>

<table class="table table-bordered align-middle shadow-sm bg-white rounded">
  <thead class="table-light">
    <tr>
      <th>Vị trí</th>
      <th>Tên menu</th>
      <th>Đường dẫn</th>
      <th>Icon</th>
      <th style="width:140px">Hành động</th>
    </tr>
  </thead>
  <tbody>
  <?php if (count($menus) === 0): ?>
    <tr>
      <td colspan="5" class="text-center text-muted">Chưa có menu nào.</td>
    </tr>
  <?php else: ?>
    <?php foreach ($menus as $menu): ?>
      <tr>
        <td class="fw-semibold text-center"><?php echo $menu['position']; ?></td>
        <td class="fw-semibold"><?php echo htmlspecialchars($menu['label']); ?></td>
        <td><a href="<?php echo htmlspecialchars($menu['url']); ?>" target="_blank" class="text-primary text-decoration-underline"><?php echo htmlspecialchars($menu['url']); ?></a></td>
        <td class="text-center">
          <?php if ($menu['icon']): ?>
            <i class="bi <?php echo htmlspecialchars($menu['icon']); ?> fs-5"></i>
            <div class="small text-muted"><?php echo htmlspecialchars($menu['icon']); ?></div>
          <?php endif; ?>
        </td>
        <td>
          <a href="index.php?page=menu&type=<?php echo $type; ?>&edit=<?php echo $menu['id']; ?>" class="btn btn-sm btn-warning me-1">Sửa</a>
          <button type="button" class="btn btn-sm btn-danger" onclick="deleteMenu(<?php echo $menu['id']; ?>)">Xoá</button>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
</tbody>
</table>

<script>
function deleteMenu(id) {
  Swal.fire({
    title: 'Bạn có chắc muốn xoá menu này?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Xoá',
    cancelButtonText: 'Huỷ'
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.innerHTML = `<input type="hidden" name="delete_id" value="${id}">`;
      document.body.appendChild(form);
      form.submit();
    }
  });
}

// Toast thông báo khi thêm/sửa/xóa
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'Thao tác thành công!',
    showConfirmButton: false,
    timer: 1800
  });
<?php endif; ?>
</script>

</div>
