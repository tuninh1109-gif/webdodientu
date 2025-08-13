<?php
require_once '../../models/Sale.php';
require_once '../../models/SaleProduct.php';
require_once '../../models/Product.php';

class SaleController {
    public function index() {
        $sales = Sale::all();
        include '../views/sale/index.php';
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],
                'status' => isset($_POST['status']) ? 1 : 0
            ];
            $id = Sale::create($data);
            header('Location: index.php?controller=sale&action=edit&id=' . $id);
            exit();
        }
        include '../views/sale/edit.php';
    }
    public function edit() {
        $id = intval($_GET['id']);
        $sale = Sale::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],
                'status' => isset($_POST['status']) ? 1 : 0
            ];
            Sale::update($id, $data);
            header('Location: index.php?controller=sale&action=index');
            exit();
        }
        include '../views/sale/edit.php';
    }
    public function delete() {
        $id = intval($_GET['id']);
        Sale::delete($id);
        header('Location: index.php?controller=sale&action=index');
        exit();
    }
    public function products() {
        $sale_id = intval($_GET['id']);
        $sale = Sale::find($sale_id);
        $sale_products = SaleProduct::allBySale($sale_id);
        $all_products = Product::getLatest(1000); // lấy tối đa 1000 sản phẩm để chọn
        include '../views/sale/products.php';
    }
    public function add_product() {
        $sale_id = intval($_POST['sale_id']);
        $data = [
            'sale_id' => $sale_id,
            'product_id' => intval($_POST['product_id']),
            'sale_price' => intval($_POST['sale_price']),
            'quantity' => intval($_POST['quantity'])
        ];
        SaleProduct::create($data);
        header('Location: index.php?controller=sale&action=products&id=' . $sale_id);
        exit();
    }
    public function update_product() {
        $id = intval($_POST['id']);
        $data = [
            'sale_price' => intval($_POST['sale_price']),
            'quantity' => intval($_POST['quantity'])
        ];
        SaleProduct::update($id, $data);
        $sale_id = intval($_POST['sale_id']);
        header('Location: index.php?controller=sale&action=products&id=' . $sale_id);
        exit();
    }
    public function delete_product() {
        $id = intval($_GET['id']);
        $sale_id = intval($_GET['sale_id']);
        SaleProduct::delete($id);
        header('Location: index.php?controller=sale&action=products&id=' . $sale_id);
        exit();
    }
}
