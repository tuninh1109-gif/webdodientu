<?php
ob_start();
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

// Lấy tham số điều hướng
$page = $_GET['page'] ?? 'dashboard';
$id = $_GET['id'] ?? null;

// Xử lý các action POST/redirect trước khi xuất HTML
switch ($page) {
  case 'danhgia_reply':
    include '../controllers/DanhGiaController.php';
    $controller = new DanhGiaController();
    $controller->admin_reply();
    exit;
  // Có thể bổ sung các action POST khác ở đây
}

// Giao diện chung (chỉ include khi không phải action POST/redirect)
include 'views/layout/header.php';
include 'views/layout/sidebar.php';

// ROUTER xử lý theo từng trang
switch ($page) {
  // Dashboard
  case 'dashboard':
    include 'views/dashboard/index.php';
    break;

  // Quản lý sản phẩm
  case 'product':
    include 'views/product/index.php';
    break;
  case 'product_add':
    include 'views/product/add.php';
    break;
  case 'product_edit':
    include 'views/product/edit.php';
    break;
  case 'product_delete':
    include 'views/product/delete.php';
    break;

  // Quản lý khuyến mại
  case 'sale':
    include 'views/sale/index.php';
    break;

  // Quản lý khuyến mại
  case 'sale':
    include 'views/sale/index.php';
    break;
  case 'sale_add':
    include 'views/sale/edit.php';
    break;
  case 'sale_edit':
    include 'views/sale/edit.php';
    break;
  case 'sale_delete':
    if (isset($_GET['id'])) {
        $sale_id = intval($_GET['id']);
        include __DIR__ . '/../config/db.php';
        mysqli_query($conn, "DELETE FROM sales WHERE id = $sale_id");
    }
    header("Location: index.php?page=sale&msg=delete_success");
    exit;
    break;
  case 'sale_products':
    include 'views/sale/products.php';
    break;

  // Quản lý banner
  case 'banner':
    include 'views/banner/index.php';
    break;
  case 'banner_add':
    include 'views/banner/add.php';
    break;
  case 'banner_edit':
    include 'views/banner/edit.php';
    break;
  case 'banner_delete':
    include 'views/banner/delete.php';
    break;

  // Quản lý đơn hàng
  case 'order':
    include 'controllers/OrderController.php';
    listOrders();
    break;
  case 'order_detail':
    include 'controllers/OrderController.php';
    viewOrderDetail($id);
    break;

  // Quản lý menu
  case 'menu':
    include 'views/menu/manage.php';
    break;
  case 'topmenu':
    include 'views/menu/manage.php';
    break;

  // Quản lý footer
  case 'footer':
    include 'views/footer/manage.php';
    break;

  // Quản lý chữ chạy
  case 'marquee':
    include 'controllers/MarqueeController.php';
    listMarquee();
    break;
  case 'marquee_add':
    include 'controllers/MarqueeController.php';
    addMarqueeForm();
    break;
  case 'marquee_edit':
    include 'controllers/MarqueeController.php';
    editMarqueeForm();
    break;
  case 'marquee_delete':
    include 'controllers/MarqueeController.php';
    deleteMarqueeItem();
    break;

  // Quản lý liên hệ
  case 'contact_admin':
    include '../controllers/ContactController.php';
    $controller = new ContactController();
    $controller->admin_index();
    break;
  case 'contact_detail':
    include '../controllers/ContactController.php';
    $controller = new ContactController();
    $controller->admin_detail();
    break;
  case 'contact_update_status':
    include '../controllers/ContactController.php';
    $controller = new ContactController();
    $controller->admin_update_status();
    break;
  case 'contact_send_mail':
    include '../controllers/ContactController.php';
    $controller = new ContactController();
    $controller->contact_send_mail();
    break;

  // Quản lý đánh giá sản phẩm
  case 'danhgia_admin':
    include '../controllers/DanhGiaController.php';
    $controller = new DanhGiaController();
    $controller->admin_index();
    break;
  case 'danhgia_reply':
    include '../controllers/DanhGiaController.php';
    $controller = new DanhGiaController();
    $controller->admin_reply();
    break;

  // Mặc định quay về dashboard
  default:
    include 'views/dashboard/index.php';
    break;
}

// Giao diện kết thúc
include 'views/layout/footer.php';
