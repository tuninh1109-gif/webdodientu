<?php
// API lấy và lưu nội dung footer cho admin/user
require_once __DIR__ . '/../../../config/db.php';
header('Content-Type: application/json');

$type = isset($_POST['type']) && $_POST['type'] === 'admin' ? 'admin' : 'user';
$action = $_POST['action'] ?? '';

if ($action === 'get') {
    $sql = "SELECT content FROM footer_content WHERE type='$type'";
    $res = mysqli_query($conn, $sql);
    $footer = mysqli_fetch_assoc($res)['content'] ?? '';
    echo json_encode(['success' => true, 'content' => $footer]);
    exit;
}

if ($action === 'save') {
    $content = trim($_POST['content'] ?? '');
    if ($content === '') {
        echo json_encode(['success' => false, 'message' => 'Nội dung footer không được để trống!']);
        exit;
    }
    $content_sql = mysqli_real_escape_string($conn, $content);
    $sql = "SELECT id FROM footer_content WHERE type='$type'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $sql = "UPDATE footer_content SET content='$content_sql' WHERE type='$type'";
    } else {
        $sql = "INSERT INTO footer_content (content, type) VALUES ('$content_sql', '$type')";
    }
    mysqli_query($conn, $sql);
    echo json_encode(['success' => true, 'message' => 'Đã lưu thành công!']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ!']);
