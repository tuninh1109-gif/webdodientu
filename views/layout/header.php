<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Điện Máy Số</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Fonts: Montserrat, Roboto -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="public/assets/css/main.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- jQuery, jQuery UI cho autocomplete -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>
<body>
<?php
if (session_status() == PHP_SESSION_NONE) session_start();
// Kết nối CSDL
$conn = mysqli_connect("localhost", "root", "", "do_dien_tu");
mysqli_set_charset($conn, "utf8");
// Lấy danh sách dòng chữ chạy cho TRANG NGƯỜI DÙNG
$marquee_sql = "SELECT noidung FROM marquee WHERE trangthai = 1 AND vaitro = 'user' ORDER BY id DESC";
$marquee_result = mysqli_query($conn, $marquee_sql);
?>
<!-- Topbar -->
<div class="topbar bg-light text-secondary py-1 small border-bottom">
  <div class="container d-flex justify-content-between align-items-center">
    <div>
      <i class="bi bi-telephone"></i> Hotline: <a href="tel:18006601" class="text-primary fw-bold text-decoration-none">1800 6601</a>
      <span class="mx-2">|</span>
      <a href="index.php?controller=contact&action=index" class="text-secondary text-decoration-none"><i class="bi bi-headset"></i> Hỗ trợ</a>
      <span class="mx-2">|</span>
      <a href="mailto:support@hihimart.vn" class="text-secondary text-decoration-none"><i class="bi bi-envelope"></i> Email</a>
    </div>
    <div>
      <a href="#" class="text-secondary text-decoration-none"><i class="bi bi-geo-alt"></i> Hệ thống cửa hàng</a>
    </div>
  </div>
</div>
<!-- Header -->
<header class="header-main shadow-sm" style="background: linear-gradient(135deg,rgb(97, 185, 252) 0%,rgb(126, 206, 235) 60%,rgb(163, 215, 245) 100%);">
  <div class="container-fluid px-lg-4 px-2">
    <div class="row align-items-center flex-nowrap py-2">
      <!-- Logo bên trái -->
      <div class="col-auto pe-0">
        <a class="logo d-flex align-items-center text-decoration-none" href="/do_dien_tu/index.php" style="gap:0.7rem;">
          <i class="bi bi-lightning-charge-fill" style="font-size:2.6rem;color:#ffe600;text-shadow:0 2px 10px #ffe60033;"></i>
          <span class="fw-bold fs-2 text-dark" style="letter-spacing:1.5px;">HihiMart</span>
        </a>
      </div>
      <!-- Slogan chỉ hiển thị desktop -->
      <div class="col d-none d-xl-block">
        <span class="slogan-header ms-3 px-3 py-1 rounded-pill fw-semibold" style="font-size:1.02rem;background:linear-gradient(90deg,#fffbe7,#e3f0ff);color:#0091ea;box-shadow:0 2px 8px #ffe60022;">Mua sắm thảnh thơi, Giá luôn tuyệt vời!</span>
      </div>
      <!-- Thanh tìm kiếm lớn giữa -->
      <div class="col-12 col-lg-5 order-lg-2 my-2 my-lg-0">
        <form class="d-flex" style="max-width: 420px; margin:0 auto;" method="get" action="index.php">
          <input type="hidden" name="controller" value="product">
          <input type="hidden" name="action" value="search">
          <input class="form-control rounded-pill me-2 px-4" type="search" name="q" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" required>
          <button class="btn btn-warning rounded-pill px-4" type="submit"><i class="bi bi-search"></i></button>
        </form>
      </div>
      <!-- Giỏ hàng và tài khoản bên phải -->
      <div class="col-auto ms-auto d-flex align-items-center gap-3 flex-shrink-0 order-lg-3">
        <div class="d-none d-xl-block fw-bold text-primary align-self-center" style="white-space:nowrap;"><i class="bi bi-telephone"></i> 1800 6601</div>
        <a class="position-relative text-dark align-self-center" href="index.php?controller=cart&action=index" style="margin-right:2px;">
          <i class="bi bi-cart3 fs-4"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.75em;">
            <?php echo $_SESSION['cart_qty'] ?? 0; ?>
          </span>
        </a>
        <?php if (empty($_SESSION['user'])): ?>
          <a class="btn btn-outline-primary rounded-pill px-3 align-self-center" href="index.php?controller=user&action=login"><i class="bi bi-person-circle"></i> Đăng nhập</a>
        <?php else: ?>
          <div class="dropdown align-self-center">
            <a class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="avatar-circle me-2"><i class="bi bi-person"></i></span>
              <span class="d-none d-md-inline-block fw-semibold"><?php echo htmlspecialchars($_SESSION['user']['tenkh'] ?? $_SESSION['user']['email']); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item d-flex align-items-center" href="views/user/profile.php"><i class="bi bi-person me-2"></i> Thông tin cá nhân</a></li>
              <li><a class="dropdown-item d-flex align-items-center" href="/do_dien_tu/index.php?controller=user&action=orders"><i class="bi bi-box-seam me-2"></i> Đơn hàng của tôi</a></li>
              <li><a class="dropdown-item d-flex align-items-center" href="views/user/loyalty.php"><i class="bi bi-heart me-2"></i> Khách hàng thân thiết</a></li>
              <li><a class="dropdown-item d-flex align-items-center" href="views/user/address.php"><i class="bi bi-geo-alt me-2"></i> Sổ địa chỉ nhận hàng</a></li>
              <li><a class="dropdown-item d-flex align-items-center" href="views/user/warranty.php"><i class="bi bi-shield-check me-2"></i> Thông tin bảo hành</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item d-flex align-items-center" href="index.php?controller=user&action=logout"><i class="bi bi-box-arrow-right me-2"></i> Đăng xuất</a></li>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <!-- Menu động dưới header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-top border-bottom py-0 mt-1">
      <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainMenu">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <?php
            $menu_sql = "SELECT * FROM menu_content WHERE type='user' ORDER BY position ASC, id ASC";
            $menu_result = mysqli_query($conn, $menu_sql);
            $menus = [];
            while ($m = mysqli_fetch_assoc($menu_result)) $menus[] = $m;
            function buildMenuTree($menus, $parent_id = null) {
                $branch = [];
                foreach ($menus as $menu) {
                    if ((is_null($parent_id) && is_null($menu['parent_id'])) || $menu['parent_id'] == $parent_id) {
                        $children = buildMenuTree($menus, $menu['id']);
                        if ($children) $menu['children'] = $children;
                        $branch[] = $menu;
                    }
                }
                return $branch;
            }
            $menu_tree = buildMenuTree($menus);
            function renderMenu($menu, $level = 0) {
                if (!empty($menu['children'])) {
                    if ($level == 0) {
                        echo '<li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle fw-semibold" href="' . htmlspecialchars($menu['url']) . '" id="menu-' . $menu['id'] . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                        if ($menu['icon']) echo '<i class="bi ' . htmlspecialchars($menu['icon']) . '"></i> ';
                        echo htmlspecialchars($menu['label']);
                        echo '</a>';
                        echo '<ul class="dropdown-menu" aria-labelledby="menu-' . $menu['id'] . '">';
                        foreach ($menu['children'] as $child) renderMenu($child, $level + 1);
                        echo '</ul>';
                        echo '</li>';
                    } else {
                        echo '<li>';
                        echo '<a class="dropdown-item" href="' . htmlspecialchars($menu['url']) . '">';
                        if ($menu['icon']) echo '<i class="bi ' . htmlspecialchars($menu['icon']) . '"></i> ';
                        echo htmlspecialchars($menu['label']);
                        echo '</a>';
                        echo '</li>';
                    }
                } else {
                    if ($level == 0) {
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link fw-semibold" href="' . htmlspecialchars($menu['url']) . '">';
                        if ($menu['icon']) echo '<i class="bi ' . htmlspecialchars($menu['icon']) . '"></i> ';
                        echo htmlspecialchars($menu['label']);
                        echo '</a>';
                        echo '</li>';
                    } else {
                        echo '<li>';
                        echo '<a class="dropdown-item" href="' . htmlspecialchars($menu['url']) . '">';
                        if ($menu['icon']) echo '<i class="bi ' . htmlspecialchars($menu['icon']) . '"></i> ';
                        echo htmlspecialchars($menu['label']);
                        echo '</a>';
                        echo '</li>';
                    }
                }
            }
            foreach ($menu_tree as $menu) {
                renderMenu($menu);
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>
    
</header>

  <!-- ĐÃ XOÁ LOGO LẶP PHÍA DƯỚI HEADER -->

<!-- ĐÃ XOÁ HOÀN TOÀN LOGO LẶP PHÍA DƯỚI HEADER, CHỈ CÒN 1 HEADER CHÍNH -->

<?php if (mysqli_num_rows($marquee_result) > 0): ?>
  <div style="background: #ffc107; padding: 6px 0;">
    <marquee behavior="scroll" direction="left" style="color: #000; font-weight: 600; font-size: 15px;">
      <?php
        $texts = [];
        while ($row = mysqli_fetch_assoc($marquee_result)) {
          $texts[] = $row['noidung'];
        }
        echo implode(' 🔔 ', $texts);
      ?>
    </marquee>
  </div>
<?php endif; ?>
