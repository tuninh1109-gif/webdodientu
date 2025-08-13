<?php
// Hiển thị dropdown chọn thương hiệu theo loại sản phẩm (AJAX sẽ dùng file này)
include(__DIR__ . '/../../../config/db.php');
$maloai = isset($_GET['maloai']) ? (int)$_GET['maloai'] : 0;
$brands = [];
if ($maloai) {
  $rs = mysqli_query($conn, "SELECT math, tenthuonghieu FROM thuonghieu WHERE maloai = $maloai");
  while ($row = mysqli_fetch_assoc($rs)) {
    $brands[] = $row;
  }
}
?>
<select name="math" id="brand-select" class="form-select" required>
  <option value="">-- Chọn thương hiệu --</option>
  <?php foreach ($brands as $brand): ?>
    <option value="<?= $brand['math'] ?>"><?= htmlspecialchars($brand['tenthuonghieu']) ?></option>
  <?php endforeach; ?>
</select>
