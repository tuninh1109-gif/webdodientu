<?php
include __DIR__ . '/../layout/header.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/config/db.php';
if (empty($_SESSION['user'])) {
    echo '<div class="container mt-4"><p>Bạn cần đăng nhập để xem sổ địa chỉ nhận hàng.</p></div>';
    include __DIR__ . '/../layout/footer.php';
    exit;
}
$user = $_SESSION['user'];
// Xử lý các thao tác thêm, xóa, đặt mặc định địa chỉ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $makh = intval($user['makh']);
    if ($_POST['action'] === 'add') {
        $ten = mysqli_real_escape_string($GLOBALS['conn'], $_POST['ten_nguoinhan']);
        $sdt = mysqli_real_escape_string($GLOBALS['conn'], $_POST['sodienthoai']);
        $diachi = mysqli_real_escape_string($GLOBALS['conn'], $_POST['diachi']);
        $mac_dinh = isset($_POST['mac_dinh']) ? 1 : 0;
        if ($mac_dinh) {
            // Bỏ mặc định các địa chỉ khác
            mysqli_query($GLOBALS['conn'], "UPDATE diachi_nhanhang SET mac_dinh=0 WHERE makh=$makh");
        }
        mysqli_query($GLOBALS['conn'], "INSERT INTO diachi_nhanhang (makh, ten_nguoinhan, diachi, sodienthoai, mac_dinh) VALUES ($makh, '$ten', '$diachi', '$sdt', $mac_dinh)");
        echo '<script>location.href=location.href;</script>';
        exit;
    }
    if ($_POST['action'] === 'delete') {
        $id = intval($_POST['id']);
        mysqli_query($GLOBALS['conn'], "DELETE FROM diachi_nhanhang WHERE id=$id AND makh=$makh");
        echo '<script>location.href=location.href;</script>';
        exit;
    }
    if ($_POST['action'] === 'set_default') {
        $id = intval($_POST['id']);
        mysqli_query($GLOBALS['conn'], "UPDATE diachi_nhanhang SET mac_dinh=0 WHERE makh=$makh");
        mysqli_query($GLOBALS['conn'], "UPDATE diachi_nhanhang SET mac_dinh=1 WHERE id=$id AND makh=$makh");
        echo '<script>location.href=location.href;</script>';
        exit;
    }
}
?>
<div class="container mt-4">
    <h4>Sổ địa chỉ nhận hàng</h4>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="list-group shadow-sm rounded-4">
                    <a href="/do_dien_tu/views/user/profile.php" class="list-group-item list-group-item-action"><i class="bi bi-person-circle me-2"></i>Thông tin cá nhân</a>
                    <a href="/do_dien_tu/index.php?controller=user&action=orders" class="list-group-item list-group-item-action"><i class="bi bi-receipt me-2"></i>Đơn hàng</a>
                    <a href="/do_dien_tu/views/user/address.php" class="list-group-item list-group-item-action active"><i class="bi bi-geo-alt me-2"></i>Địa chỉ</a>
                    <a href="/do_dien_tu/views/user/warranty.php" class="list-group-item list-group-item-action"><i class="bi bi-shield-check me-2"></i>Bảo hành</a>
                    <a href="/do_dien_tu/index.php?controller=user&action=logout" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a>
                </div>
            </div>
            <div class="col-md-9">
    <div class="card p-4 shadow-sm rounded-4">
        <h3 class="mb-4"><i class="bi bi-geo-alt me-2"></i>Sổ địa chỉ</h3>
        <?php
        // Lấy danh sách địa chỉ nhận hàng
        $makh = intval($user['makh']);
        $diachis = [];
        $rs = mysqli_query($GLOBALS['conn'], "SELECT * FROM diachi_nhanhang WHERE makh = $makh ORDER BY mac_dinh DESC, id DESC");
        while ($row = mysqli_fetch_assoc($rs)) $diachis[] = $row;
        ?>
        <div class="d-flex flex-wrap gap-3">
            <?php foreach ($diachis as $dc): ?>
            <div class="address-card card shadow-sm mb-2 border-<?= $dc['mac_dinh'] ? 'success' : 'secondary' ?> position-relative" style="min-width:300px; max-width:340px; flex:1 1 320px;">
                <?php if ($dc['mac_dinh']): ?>
                    <span class="badge bg-success position-absolute top-0 end-0 m-2">Mặc định</span>
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title mb-1"><i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($dc['ten_nguoinhan']) ?></h5>
                    <p class="mb-1"><i class="bi bi-geo-alt me-1"></i> <?= htmlspecialchars($dc['diachi']) ?></p>
                    <p class="mb-2"><i class="bi bi-telephone me-1"></i> <?= htmlspecialchars($dc['sodienthoai']) ?></p>
                    <div class="d-flex gap-2">
                        <?php if (!$dc['mac_dinh']): ?>
                            <form method="POST" style="display:inline-block">
                                <input type="hidden" name="action" value="set_default">
                                <input type="hidden" name="id" value="<?= $dc['id'] ?>">
                                <button class="btn btn-outline-primary btn-sm px-3" type="submit"><i class="bi bi-star"></i> Đặt mặc định</button>
                            </form>
                        <?php endif; ?>
                        <form method="POST" style="display:inline-block" onsubmit="return confirm('Bạn chắc chắn muốn xóa địa chỉ này?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $dc['id'] ?>">
                            <button class="btn btn-outline-danger btn-sm px-3" type="submit"><i class="bi bi-trash"></i> Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
                    <hr>
                    <h5 class="mb-3">Thêm địa chỉ mới</h5>
                    <form method="POST" class="row g-3 p-3 bg-light rounded-4 shadow-sm border border-2 border-success-subtle" style="max-width:600px">
    <input type="hidden" name="action" value="add">
    <h5 class="mb-3 text-success"><i class="bi bi-plus-circle me-1"></i> Thêm địa chỉ mới</h5>
    <div class="col-md-6">
        <label for="ten_nguoinhan" class="form-label">Họ tên người nhận</label>
        <input type="text" name="ten_nguoinhan" id="ten_nguoinhan" class="form-control" placeholder="Họ tên người nhận" required>
    </div>
    <div class="col-md-6">
        <label for="sodienthoai" class="form-label">Số điện thoại</label>
        <input type="text" name="sodienthoai" id="sodienthoai" class="form-control" placeholder="Số điện thoại" required>
    </div>
    <div class="col-12">
        <label for="diachi" class="form-label">Địa chỉ nhận hàng</label>
        <input type="text" name="diachi" id="diachi" class="form-control" placeholder="Địa chỉ nhận hàng" required>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="mac_dinh" value="1" id="mac_dinh">
            <label class="form-check-label" for="mac_dinh">Đặt làm mặc định</label>
        </div>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-success px-4 py-2"><i class="bi bi-save me-1"></i> Thêm địa chỉ</button>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
