<?php
include 'views/layout/header.php';

// Kiểm tra nếu có session user thì lấy email/sđt từ session, nếu không thì yêu cầu nhập
$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
$sodienthoai = isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : '';

if (empty($email) && empty($sodienthoai)) {
    // Form tra cứu đơn hàng nếu chưa đăng nhập
    echo '<div class="container mt-4">';
    echo '<h4>Tra cứu đơn hàng</h4>';
    echo '<form method="POST">';
    echo '<div class="mb-3"><label>Email hoặc Số điện thoại:</label><input type="text" name="keyword" class="form-control" required></div>';
    echo '<button type="submit" class="btn btn-primary">Xem đơn hàng</button>';
    echo '</form>';
    echo '</div>';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $keyword = $_POST['keyword'];
        $where = "email = '$keyword' OR sodienthoai = '$keyword'";
    } else {
        $where = null;
    }
} else {
    // Đã đăng nhập
    $where = "email = '$email' OR sodienthoai = '$sodienthoai'";
}

if ($where) {
    require_once 'config/db.php';
    // Lấy mã khách hàng
    $sql_kh = "SELECT makh FROM khachhang WHERE $where";
    $result_kh = mysqli_query($GLOBALS['conn'], $sql_kh);
    $makh = mysqli_fetch_assoc($result_kh)['makh'] ?? null;
    if ($makh) {
        // Lấy danh sách đơn hàng
        $sql_dh = "SELECT * FROM donhang WHERE makh = $makh ORDER BY madon DESC";
        $result_dh = mysqli_query($GLOBALS['conn'], $sql_dh);
        echo '<div class="container mt-4">';
        if (!empty($_SESSION['alert_myorders'])) {
    echo $_SESSION['alert_myorders'];
    unset($_SESSION['alert_myorders']);
}
echo '<h4>Đơn hàng của bạn</h4>';
// Filter trạng thái
$filter = isset($_GET['filter']) ? intval($_GET['filter']) : -1;
echo '<form method="get" class="mb-3 d-flex align-items-center gap-2">';
echo '<input type="hidden" name="controller" value="order">';
echo '<input type="hidden" name="action" value="myorders">';
echo '<select name="filter" class="form-select w-auto">';
echo '<option value="-1"' . ($filter===-1?' selected':'') . '>Tất cả trạng thái</option>';
foreach ($trangthai_map as $k=>$v) {
    echo '<option value="'.$k.'"'.($filter===$k?' selected':'').'>'.$v['label'].'</option>';
}
echo '</select>';
echo '<button type="submit" class="btn btn-outline-primary btn-sm">Lọc</button>';
echo '</form>';
        if (mysqli_num_rows($result_dh) > 0) {
            echo '<table class="table table-bordered"><thead><tr><th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th><th></th></tr></thead><tbody>';
            while ($row = mysqli_fetch_assoc($result_dh)) {
    // Nếu filter trạng thái, bỏ qua đơn không khớp
    if ($filter !== -1 && intval($row['trangthai']) !== $filter) continue;
                echo '<tr>';
                echo '<td>' . $row['madon'] . '</td>';
                echo '<td>' . $row['ngaydat'] . '</td>';
                echo '<td>' . number_format($row['tongtien']) . ' đ</td>';
                // Map trạng thái số sang chuỗi và badge
$trangthai_map = [
    0 => ['label' => 'Chờ xác nhận', 'badge' => 'secondary'],
    1 => ['label' => 'Đã duyệt', 'badge' => 'info'],
    2 => ['label' => 'Đang giao', 'badge' => 'primary'],
    3 => ['label' => 'Đã giao', 'badge' => 'success'],
    4 => ['label' => 'Đã nhận', 'badge' => 'success'],
    5 => ['label' => 'Đã hủy', 'badge' => 'danger'],
];
$status = isset($row['trangthai']) ? intval($row['trangthai']) : 0;
$statusInfo = $trangthai_map[$status] ?? $trangthai_map[0];
echo '<td><span class="badge bg-' . $statusInfo['badge'] . '">' . $statusInfo['label'] . '</span></td>';
                echo '<td>';
echo '<a href="index.php?controller=order&action=order_detail&madon=' . $row['madon'] . '" class="btn btn-info btn-sm">Xem chi tiết</a> ';
// Nút hủy đơn nếu trạng thái = 0
if ($status === 0) {
    echo '<a href="index.php?controller=order&action=huydon&madon=' . $row['madon'] . '" class="btn btn-danger btn-sm ms-1" onclick="return confirm(\'Bạn chắc chắn muốn hủy đơn này?\');">Hủy đơn</a>';
}
echo '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p>Bạn chưa có đơn hàng nào.</p>';
        }
        echo '</div>';
    } else {
        echo '<div class="container mt-4"><p>Không tìm thấy đơn hàng với thông tin đã nhập.</p></div>';
    }
}

include 'views/layout/footer.php';
