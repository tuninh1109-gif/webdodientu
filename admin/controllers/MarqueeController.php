<?php
include_once __DIR__ . '/../models/Marquee.php';

function listMarquee() {
  $marquees = getAllMarquee();
  include __DIR__ . '/../views/marquee/index.php';
}

function addMarqueeForm() {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noidung = $_POST['noidung'];
    $vaitro = $_POST['vaitro'];
    $trangthai = isset($_POST['trangthai']) ? 1 : 0;
    addMarquee($noidung, $vaitro, $trangthai);
    header('Location: index.php?page=marquee');
    exit;
  }
  include __DIR__ . '/../views/marquee/add.php';
}

function editMarqueeForm() {
  $id = $_GET['id'] ?? 0;
  $marquee = mysqli_fetch_assoc(getMarqueeById($id));

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noidung = $_POST['noidung'];
    $vaitro = $_POST['vaitro'];
    $trangthai = isset($_POST['trangthai']) ? 1 : 0;
    updateMarquee($id, $noidung, $vaitro, $trangthai);
    header('Location: index.php?page=marquee');
    exit;
  }

  include __DIR__ . '/../views/marquee/edit.php';
}

function deleteMarqueeItem() {
  $id = $_GET['id'] ?? 0;
  deleteMarquee($id);
  header('Location: index.php?page=marquee');
  exit;
}
