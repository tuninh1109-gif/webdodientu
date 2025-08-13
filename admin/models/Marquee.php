<?php
include_once(__DIR__ . '/../../config/db.php');

function getAllMarquee() {
  global $conn;
  $sql = "SELECT * FROM marquee ORDER BY id DESC";
  return mysqli_query($conn, $sql);
}

function getMarqueeById($id) {
  global $conn;
  $sql = "SELECT * FROM marquee WHERE id = $id";
  return mysqli_query($conn, $sql);
}

function addMarquee($noidung, $vaitro = 'user', $trangthai = 1) {
  global $conn;
  $sql = "INSERT INTO marquee (noidung, vaitro, trangthai) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ssi", $noidung, $vaitro, $trangthai);
  return mysqli_stmt_execute($stmt);
}

function updateMarquee($id, $noidung, $vaitro = 'user', $trangthai = 1) {
  global $conn;
  $sql = "UPDATE marquee SET noidung = ?, vaitro = ?, trangthai = ? WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ssii", $noidung, $vaitro, $trangthai, $id);
  return mysqli_stmt_execute($stmt);
}

function deleteMarquee($id) {
  global $conn;
  $sql = "DELETE FROM marquee WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  return mysqli_stmt_execute($stmt);
}
