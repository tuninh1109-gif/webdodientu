<?php
// Kết nối CSDL trước
include(__DIR__ . '/../../../config/db.php');
// Lấy danh sách chương trình sale
$sales = mysqli_query($conn, "SELECT * FROM sales ORDER BY id DESC");
?>
<?php
// Hiển thị thông báo thành công nếu có
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'add_success') {
        echo '<div class="alert alert-success">Thêm chương trình thành công!</div>';
    }
    if ($_GET['msg'] === 'delete_success') {
        echo '<div class="alert alert-success">Xóa chương trình thành công!</div>';
    }
    if ($_GET['msg'] === 'edit_success') {
        echo '<div class="alert alert-success">Cập nhật chương trình thành công!</div>';
    }
}
?>
<div class="container mt-4">
  <h2>Danh sách chương trình Sale</h2>
  <a href="index.php?page=sale_add" class="btn btn-success mb-3">+ Thêm chương trình Sale</a>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tên chương trình</th>
        <th>Bắt đầu</th>
        <th>Kết thúc</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($sales)): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo $row['start_time']; ?></td>
        <td><?php echo $row['end_time']; ?></td>
        <td><?php echo $row['status'] ? '<span class="badge bg-success">Bật</span>' : '<span class="badge bg-secondary">Tắt</span>'; ?></td>
        <td>
          <a href="index.php?page=sale_edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
          <a href="index.php?page=sale_delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa chương trình này?');">Xóa</a>
          <a href="index.php?page=sale_products&id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Quản lý sản phẩm</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include(__DIR__ . '/../layout/footer.php'); ?>
