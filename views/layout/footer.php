<?php
$sql = "SELECT content FROM footer_content WHERE type='user'";
$res = mysqli_query($conn, $sql);
$footer = mysqli_fetch_assoc($res)['content'] ?? '';
if ($footer) {
    echo $footer;
}
?>
<!-- Bootstrap Bundle JS (for Carousel, Modal, Dropdown, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
