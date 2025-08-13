<?php
include(__DIR__ . '/../../../config/db.php');

// Xác định chế độ sửa hay thêm
$sale = null;
$alert = '';
$isEdit = false;
if (isset($_GET['id'])) {
    $isEdit = true;
    $sale_id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM sales WHERE id = $sale_id");
    $sale = mysqli_fetch_assoc($result);
    if (!$sale) {
        $alert = '<div class="alert alert-danger">Không tìm thấy chương trình Sale!</div>';
    }
}

// Xử lý submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = isset($_POST['status']) ? 1 : 0;

    if ($isEdit && $sale) {
        // Sửa
        $sql = "UPDATE sales SET title=?, description=?, start_time=?, end_time=?, status=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssii", $title, $description, $start_time, $end_time, $status, $sale_id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?page=sale&msg=edit_success");
            exit;
        } else {
            $alert = '<div class="alert alert-danger">Cập nhật thất bại!</div>';
        }
    } elseif (!$isEdit) {
        // Thêm mới
        $sql = "INSERT INTO sales (title, description, start_time, end_time, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $title, $description, $start_time, $end_time, $status);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?page=sale&msg=add_success");
            exit;
        } else {
            $alert = '<div class="alert alert-danger">Thêm chương trình thất bại!</div>';
        }
    }
}

?>
<div class="container mt-4">
  <h2><?php echo isset($sale) ? 'Sửa' : 'Thêm'; ?> chương trình Sale</h2>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">Tên chương trình</label>
      <input type="text" name="title" class="form-control" required value="<?php echo $sale['title'] ?? ''; ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Mô tả</label>
      <textarea name="description" class="form-control" rows="3"><?php echo $sale['description'] ?? ''; ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Thời gian bắt đầu</label>
      <input type="datetime-local" name="start_time" class="form-control" required value="<?php echo isset($sale['start_time']) ? date('Y-m-d\TH:i', strtotime($sale['start_time'])) : ''; ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Thời gian kết thúc</label>
      <input type="datetime-local" name="end_time" class="form-control" required value="<?php echo isset($sale['end_time']) ? date('Y-m-d\TH:i', strtotime($sale['end_time'])) : ''; ?>">
    </div>
    <div class="mb-3 form-check">
      <input type="checkbox" name="status" class="form-check-input" id="status" <?php echo (isset($sale['status']) && $sale['status']) ? 'checked' : ''; ?>>
      <label class="form-check-label" for="status">Bật chương trình</label>
    </div>
    <button type="submit" class="btn btn-success">Lưu</button>
    <a href="index.php?controller=sale&action=index" class="btn btn-secondary">Quay lại</a>
  </form>
</div>
<?php include(__DIR__ . '/../layout/footer.php'); ?>
