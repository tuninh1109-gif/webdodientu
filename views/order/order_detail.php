<?php
include 'views/layout/header.php';
require_once 'config/db.php';

// Handle review submit
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action']) && $_POST['action']==='danhgia' && isset($_SESSION['user'])) {
    $makh = intval($_SESSION['user']['makh']);
    $masp = intval($_POST['masp']);
    $madon = intval($_POST['madon']);
    $diem = intval($_POST['diem']);
    $noidung = trim(mysqli_real_escape_string($GLOBALS['conn'], $_POST['noidung']));
    // Kiểm tra quyền đánh giá: user phải là chủ đơn, đơn đã nhận, sản phẩm thuộc đơn, chưa đánh giá
    $sql_check = "SELECT d.madon FROM donhang d JOIN chitietdonhang ct ON d.madon=ct.madon WHERE d.madon=$madon AND d.makh=$makh AND d.trangthai=4 AND ct.masp=$masp";
    $rs_check = mysqli_query($GLOBALS['conn'], $sql_check);
    if (mysqli_num_rows($rs_check)>0) {
        // Kiểm tra đã đánh giá chưa
        $sql_check2 = "SELECT id FROM danhgia WHERE makh=$makh AND masp=$masp AND madon=$madon";
        $rs_check2 = mysqli_query($GLOBALS['conn'], $sql_check2);
        if (mysqli_num_rows($rs_check2)==0) {
            $sql_insert = "INSERT INTO danhgia (makh, masp, madon, diem, noidung) VALUES ($makh, $masp, $madon, $diem, '$noidung')";
            mysqli_query($GLOBALS['conn'], $sql_insert);
        }
    }
    echo '<script>location.href=location.href;</script>';
    exit;
}

if (!isset($_GET['madon'])) {
    echo '<div class="container mt-4"><p>Không tìm thấy mã đơn hàng.</p></div>';
    include 'views/layout/footer.php';
    exit;
}
$madon = intval($_GET['madon']);

// Lấy thông tin đơn hàng
$sql_dh = "SELECT donhang.*, khachhang.tenkh, khachhang.email, khachhang.diachi, khachhang.sodienthoai FROM donhang JOIN khachhang ON donhang.makh = khachhang.makh WHERE madon = $madon";
$result_dh = mysqli_query($GLOBALS['conn'], $sql_dh);
$order = mysqli_fetch_assoc($result_dh);
if (!$order) {
    echo '<div class="container mt-4"><p>Không tìm thấy đơn hàng.</p></div>';
    include 'views/layout/footer.php';
    exit;
}

// Lấy chi tiết sản phẩm đã mua
$sql_ct = "SELECT chitietdonhang.*, sanpham.tensp, sanpham.hinhanh FROM chitietdonhang JOIN sanpham ON chitietdonhang.masp = sanpham.masp WHERE madon = $madon";
$result_ct = mysqli_query($GLOBALS['conn'], $sql_ct);

// Mapping trạng thái số sang chuỗi
$trangthai_map = [
    0 => 'Chờ xác nhận',
    1 => 'Đã duyệt',
    2 => 'Đang giao',
    3 => 'Đã giao',
    4 => 'Đã nhận',
    5 => 'Đã hủy',
];
$trangthai_key = isset($order['trangthai']) ? intval($order['trangthai']) : 0;
$trangthai = $trangthai_map[$trangthai_key] ?? 'Chờ xác nhận';

?>
<div class="container mt-4">
  <h4 class="mb-4">Chi tiết đơn hàng #<?php echo $order['madon']; ?></h4>
  <!-- Stepper trạng thái đơn hàng -->
  <?php
    // Stepper trạng thái TMĐT
    $steps = [
      ['label'=>'Chờ xác nhận', 'icon'=>'bi-clock'],      // 0
      ['label'=>'Đã duyệt', 'icon'=>'bi-clipboard-check'], // 1
      ['label'=>'Đang giao', 'icon'=>'bi-truck'],         // 2
      ['label'=>'Đã giao', 'icon'=>'bi-box-seam'],        // 3
      ['label'=>'Đã hủy', 'icon'=>'bi-x-circle'],         // 5
    ];
    // Tô màu: done, active, cancel
    function step_color($idx, $trangthai_key) {
      if ($trangthai_key == 5 && $idx != 4) return 'secondary'; // Nếu đã hủy, chỉ tô đỏ bước cuối
      if ($trangthai_key == 5 && $idx == 4) return 'danger';
      if ($trangthai_key == $idx) return 'primary';
      if ($trangthai_key > $idx && $trangthai_key != 5) return 'success';
      return 'secondary';
    }
  ?>
  <div class="order-stepper d-flex justify-content-between align-items-center mb-4 flex-wrap" style="gap:0.5rem;">
    <?php foreach ($steps as $i=>$step):
      if ($i==4 && $trangthai_key!=5) continue; // Chỉ hiện bước Hủy nếu trạng thái là Hủy
      $color = step_color($i, $trangthai_key);
    ?>
    <div class="text-center flex-fill" style="min-width:110px;">
      <span class="step-circle bg-<?php echo $color; ?> text-white mb-2" style="display:inline-block;width:38px;height:38px;line-height:38px;border-radius:50%;font-size:1.3rem;"><i class="bi <?php echo $step['icon']; ?>"></i></span><br>
      <span class="fw-semibold text-<?php echo $color; ?>"><?php echo $step['label']; ?></span>
    </div>
    <?php if ($i < 3 && !($trangthai_key==5 && $i==3)): ?>
      <div style="height:4px;flex:1 1 20px;background:#dee2e6;margin:0 2px;position:relative;top:-18px;"></div>
    <?php endif; ?>
    <?php endforeach; ?>
  </div>
  <!-- Box thông tin đơn hàng -->
  <div class="card p-3 mb-4 shadow-sm rounded-4">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="mb-2"><i class="bi bi-person me-2"></i><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['tenkh']); ?></div>
        <div class="mb-2"><i class="bi bi-envelope me-2"></i><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></div>
        <div class="mb-2"><i class="bi bi-geo-alt me-2"></i><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['diachi']); ?></div>
        <div class="mb-2"><i class="bi bi-telephone me-2"></i><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['sodienthoai']); ?></div>
      </div>
      <div class="col-md-6">
        <div class="mb-2"><i class="bi bi-calendar me-2"></i><strong>Ngày đặt:</strong> <?php echo $order['ngaydat']; ?></div>
        <div class="mb-2"><i class="bi bi-info-circle me-2"></i><strong>Trạng thái:</strong> <span class="badge bg-info text-dark fs-6"><?php echo $trangthai; ?></span>
<?php if ($trangthai_key==2): ?>
  <a href="index.php?controller=order&action=confirm_received&madon=<?php echo $order['madon']; ?>" class="btn btn-success ms-3" onclick="return confirm('Bạn chắc chắn đã nhận được hàng?');">Tôi đã nhận hàng</a>
<?php elseif ($trangthai_key==3): ?>
  <span class="badge bg-success ms-3">Đã nhận hàng</span>
<?php endif; ?>
</div>
        <div class="mb-2"><i class="bi bi-cash-coin me-2"></i><strong>Tổng tiền:</strong> <span class="text-danger fw-bold fs-5"><?php echo number_format($order['tongtien']); ?> đ</span></div>
      </div>
    </div>
  </div>
  <!-- Bảng sản phẩm đã mua -->
  <h5 class="mb-3">Sản phẩm đã mua</h5>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>Ảnh</th>
          <th>Tên sản phẩm</th>
          <th>Số lượng</th>
          <th>Đơn giá</th>
          <th>Thành tiền</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($item = mysqli_fetch_assoc($result_ct)): ?>
<tr>
  <td><img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($item['hinhanh']); ?>"
    width="64" height="64" style="object-fit:cover;border-radius:12px;background:#f6fafd;box-shadow:0 2px 8px rgba(33,150,243,0.10);"
    alt="<?php echo htmlspecialchars($item['tensp']); ?>"
    onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';"></td>
  <td>
    <b><?php echo htmlspecialchars($item['tensp']); ?></b>
    <br>
    <?php
      // Lấy tất cả đánh giá cho sản phẩm này
      $masp = intval($item['masp']);
      $sql_all_reviews = "SELECT dg.*, kh.tenkh FROM danhgia dg JOIN khachhang kh ON dg.makh = kh.makh WHERE masp=$masp ORDER BY thoigian DESC";
      $rs_reviews = mysqli_query($GLOBALS['conn'], $sql_all_reviews);
      $reviews = [];
      $star_count = [1=>0,2=>0,3=>0,4=>0,5=>0];
      while ($r = mysqli_fetch_assoc($rs_reviews)) {
        $reviews[] = $r;
        $star_count[$r['diem']]++;
      }
      $total_reviews = count($reviews);
      // Kiểm tra user đã đánh giá chưa
      $my_review = null;
      foreach ($reviews as $rv) {
        if (isset($_SESSION['user']) && $rv['makh']==$_SESSION['user']['makh'] && $rv['madon']==$madon) {
          $my_review = $rv;
          break;
        }
      }
    ?>
    <div class="mt-2 p-3 bg-light rounded-3">
      <b>Đánh giá & bình luận</b>
      <div class="d-flex align-items-center mb-2 gap-2">
        <span class="fw-bold me-2"><?php echo $total_reviews; ?> Bình luận</span>
        <?php for($s=5;$s>=1;$s--): ?>
          <a href="#" class="badge bg-white border text-dark me-1" onclick="event.preventDefault();filterStars(this,<?php echo $masp; ?>,<?php echo $s; ?>)"><?php echo $s; ?> <i class="bi bi-star-fill text-warning"></i> (<?php echo $star_count[$s]; ?>)</a>
        <?php endfor; ?>
        <a href="#" class="badge bg-danger text-white ms-2" onclick="event.preventDefault();filterStars(this,<?php echo $masp; ?>,0)">Tất cả</a>
      </div>
      <div id="review-list-<?php echo $masp; ?>">
        <?php if ($total_reviews==0): ?>
          <div class="alert alert-warning">Trở thành người đầu tiên đánh giá về sản phẩm.</div>
        <?php else: ?>
          <?php foreach ($reviews as $rv): ?>
            <div class="border-bottom py-2 mb-2">
              <b><?php echo htmlspecialchars($rv['tenkh']); ?></b>
              <span class="ms-2 text-warning">
                <?php for($i=1;$i<=5;$i++) echo $i<=$rv['diem']?'<i class="bi bi-star-fill"></i>':'<i class="bi bi-star"></i>'; ?>
              </span>
              <span class="text-muted ms-2" style="font-size:12px"><?php echo date('d/m/Y H:i',strtotime($rv['thoigian'])); ?></span>
              <div><?php echo nl2br(htmlspecialchars($rv['noidung'])); ?></div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <?php if ($order['trangthai']==4 && !$my_review && isset($_SESSION['user'])): ?>
        <form method="post" class="mt-3">
          <input type="hidden" name="action" value="danhgia">
          <input type="hidden" name="masp" value="<?php echo $masp; ?>">
          <input type="hidden" name="madon" value="<?php echo $madon; ?>">
          <div class="mb-2">
            <b>Đánh giá của bạn:</b>
            <span id="star-select-<?php echo $masp; ?>">
              <?php for($i=1;$i<=5;$i++): ?>
                <input type="radio" name="diem" value="<?php echo $i; ?>" id="star-<?php echo $masp.'-'.$i; ?>" required>
                <label for="star-<?php echo $masp.'-'.$i; ?>" style="color:orange;font-size:20px;cursor:pointer;">&#9733;</label>
              <?php endfor; ?>
            </span>
          </div>
          <div class="mb-2">
            <textarea name="noidung" class="form-control" rows="2" maxlength="1000" placeholder="Nhập nội dung bình luận..." required></textarea>
          </div>
          <button class="btn btn-danger" type="submit">Gửi đánh giá</button>
        </form>
      <?php elseif ($my_review): ?>
        <div class="alert alert-success mt-2">Bạn đã đánh giá sản phẩm này.</div>
      <?php endif; ?>
    </div>
  </td>
  <td><?php echo $item['soluong']; ?></td>
  <td><?php echo number_format($item['dongia']); ?> đ</td>
  <td><?php echo number_format($item['dongia'] * $item['soluong']); ?> đ</td>
</tr>
<?php endwhile; ?>
        </tbody>
    </table>
    <a href="index.php?controller=order&action=myorders" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
</div>
<?php
include 'views/layout/footer.php';
?>
