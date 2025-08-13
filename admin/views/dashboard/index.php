<?php

include(__DIR__ . '/../../../config/db.php');

// Năm hiện tại
$year = date('Y');

// Tổng doanh thu
$tongdoanhthu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(tongtien) as total FROM donhang"))['total'] ?? 0;

// Tổng đơn hàng
$tongdon = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM donhang"))['total'] ?? 0;

// Tổng sản phẩm
$tongsp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM sanpham"))['total'] ?? 0;

// Doanh thu theo tháng
$doanhthu_thang = [];
for ($i = 1; $i <= 12; $i++) {
    $query = "SELECT SUM(tongtien) AS total 
              FROM donhang 
              WHERE MONTH(ngaydat) = $i AND YEAR(ngaydat) = $year";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $doanhthu_thang[] = $row['total'] ?? 0;
}

// Top sản phẩm bán chạy
$best_products = mysqli_query($conn, "
    SELECT sp.tensp, SUM(ct.soluong) as total 
    FROM chitietdonhang ct
    JOIN sanpham sp ON ct.masp = sp.masp
    GROUP BY ct.masp 
    ORDER BY total DESC 
    LIMIT 5
");
$labels = $data = [];
while ($row = mysqli_fetch_assoc($best_products)) {
    $labels[] = $row['tensp'];
    $data[] = $row['total'];
}
?>

<div class="container mt-4">
  <h3 class="mb-4">📊 Tổng quan hệ thống</h3>
  <div class="row text-center mb-4 g-3">
    <div class="col-md-4 col-12">
      <div class="card shadow rounded-4 border-0 stat-card h-100 bg-gradient bg-success-subtle position-relative overflow-hidden">
        <div class="card-body py-4">
          <div class="display-5 mb-2"><span class="bi bi-cash-coin text-success"></span></div>
          <h5 class="fw-bold">Tổng doanh thu</h5>
          <h2 class="fw-bolder text-success-emphasis mt-2" style="font-size:2.2rem;"><?= number_format($tongdoanhthu, 0, ',', '.') ?> ₫</h2>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-12">
      <div class="card shadow rounded-4 border-0 stat-card h-100 bg-gradient bg-primary-subtle position-relative overflow-hidden">
        <div class="card-body py-4">
          <div class="display-5 mb-2"><span class="bi bi-cart-check text-primary"></span></div>
          <h5 class="fw-bold">Tổng đơn hàng</h5>
          <h2 class="fw-bolder text-primary-emphasis mt-2" style="font-size:2.2rem;"><?= $tongdon ?></h2>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-12">
      <div class="card shadow rounded-4 border-0 stat-card h-100 bg-gradient bg-warning-subtle position-relative overflow-hidden">
        <div class="card-body py-4">
          <div class="display-5 mb-2"><span class="bi bi-box-seam text-warning"></span></div>
          <h5 class="fw-bold">Tổng sản phẩm</h5>
          <h2 class="fw-bolder text-warning-emphasis mt-2" style="font-size:2.2rem;"><?= $tongsp ?></h2>
        </div>
      </div>
    </div>
  </div>
  <style>
    .stat-card {
      transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover {
      transform: translateY(-4px) scale(1.03);
      box-shadow: 0 8px 32px 0 rgba(0,0,0,0.12);
    }
  </style>

  <div class="row g-4">
    <div class="col-lg-8 col-12">
      <div class="card p-4 shadow h-100">
        <h5 class="mb-3">📉 Doanh thu theo tháng (Line Chart)</h5>
        <canvas id="lineChart" height="120"></canvas>
      </div>
    </div>
    <div class="col-lg-4 col-12">
      <div class="card p-4 shadow h-100">
        <h5 class="mb-3">🏆 Top 5 sản phẩm bán chạy</h5>
        <canvas id="topProductBar" height="220"></canvas>
      </div>
    </div>
    <div class="col-12">
      <div class="card p-4 shadow mt-3">
        <h5 class="mb-3">📊 Doanh thu theo tháng (Bar Chart)</h5>
        <canvas id="barChart" height="120"></canvas>
      </div>
    </div>
    <div class="col-12">
      <div class="card p-4 shadow mt-3">
        <h5 class="mb-3">📋 Bảng chi tiết Top sản phẩm bán chạy</h5>
        <div class="table-responsive">
          <table class="table table-sm table-bordered align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Sản phẩm</th>
                <th>Số lượng bán</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($labels as $i => $tensp): ?>
              <tr>
                <td class="text-center fw-bold"><?= $i+1 ?></td>
                <td><?= htmlspecialchars($tensp) ?></td>
                <td class="text-end fw-semibold text-primary-emphasis"><?= $data[$i] ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Đơn hàng mới nhất -->
    <div class="col-lg-7 col-12">
      <div class="card p-4 shadow mt-3 h-100">
        <h5 class="mb-3">🆕 Đơn hàng mới nhất</h5>
        <div class="table-responsive">
          <table class="table table-sm table-bordered align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $orders = mysqli_query($conn, "SELECT d.madon, k.tenkh, d.ngaydat, d.tongtien, d.trangthai FROM donhang d LEFT JOIN khachhang k ON d.makh = k.makh ORDER BY d.ngaydat DESC LIMIT 5");
              while ($row = mysqli_fetch_assoc($orders)):
                $status = strtolower($row['trangthai']);
                $badge = 'secondary';
                if ($status == 'đã giao') $badge = 'success';
                else if ($status == 'chờ duyệt') $badge = 'warning';
                else if ($status == 'đã hủy') $badge = 'danger';
              ?>
              <tr>
                <td class="fw-bold">#<?= $row['madon'] ?></td>
                <td><?= htmlspecialchars($row['tenkh'] ?? 'Ẩn') ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row['ngaydat'])) ?></td>
                <td class="text-danger fw-bold"><?= number_format($row['tongtien']) ?> ₫</td>
                <td><span class="badge bg-<?= $badge ?> text-capitalize"><?= $row['trangthai'] ?></span></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Thông báo nội bộ -->
    <div class="col-lg-5 col-12">
      <div class="card p-4 shadow mt-3 h-100 bg-warning-subtle">
        <h5 class="mb-3"><span class="bi bi-megaphone"></span> Thông báo nội bộ</h5>
        <ul class="list-unstyled mb-0" style="font-size:1.05rem;">
          <?php
          $marquees = mysqli_query($conn, "SELECT noidung, ngaytao FROM marquee WHERE trangthai = 1 AND vaitro = 'admin' ORDER BY id DESC LIMIT 5");
          if (mysqli_num_rows($marquees) == 0) echo '<li class="text-muted">Không có thông báo nào.</li>';
          while ($mq = mysqli_fetch_assoc($marquees)):
          ?>
          <li class="mb-2 d-flex align-items-center gap-2">
            <span class="bi bi-dot text-warning fs-4"></span>
            <span><?= htmlspecialchars($mq['noidung']) ?></span>
            <span class="ms-auto text-secondary small">(<?= date('d/m', strtotime($mq['ngaytao'])) ?>)</span>
          </li>
          <?php endwhile; ?>
        </ul>
      </div>
    </div>
    <!-- Hoạt động gần đây -->
    <div class="col-12">
      <div class="card p-4 shadow mt-3">
        <h5 class="mb-3"><span class="bi bi-clock-history"></span> Hoạt động gần đây</h5>
        <ul class="list-group list-group-flush">
          <?php
          $logs = @mysqli_query($conn, "SELECT noidung, thoigian FROM log_admin ORDER BY thoigian DESC LIMIT 5");
          if ($logs && mysqli_num_rows($logs) > 0) {
            while ($log = mysqli_fetch_assoc($logs)) {
          ?>
          <li class="list-group-item d-flex align-items-center gap-2">
            <span class="bi bi-arrow-right-short text-primary fs-4"></span>
            <span><?= htmlspecialchars($log['noidung']) ?></span>
            <span class="ms-auto text-secondary small"><span class="bi bi-clock"></span> <?= date('d/m/Y H:i', strtotime($log['thoigian'])) ?></span>
          </li>
          <?php
            }
          } else {
            echo '<li class="list-group-item text-muted">Không có hoạt động nào gần đây.</li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const doanhthuThang = <?= json_encode($doanhthu_thang) ?>;
const bestLabels = <?= json_encode($labels) ?>;
const bestData = <?= json_encode($data) ?>;

// Biểu đồ đường (line)
new Chart(document.getElementById('lineChart'), {
  type: 'line',
  data: {
    labels: ['Th1','Th2','Th3','Th4','Th5','Th6','Th7','Th8','Th9','Th10','Th11','Th12'],
    datasets: [{
      label: 'Doanh thu (VNĐ)',
      data: doanhthuThang,
      borderColor: '#36a2eb',
      backgroundColor: 'rgba(54, 162, 235, 0.2)',
      tension: 0.4,
      fill: true,
      borderWidth: 2
    }]
  },
  options: {
    scales: {
      y: {
        ticks: {
          callback: value => value.toLocaleString('vi-VN') + ' ₫'
        }
      }
    },
    plugins: {
      legend: { display: false }
    }
  }
});

// Biểu đồ bar ngang sản phẩm bán chạy
new Chart(document.getElementById('topProductBar'), {
  type: 'bar',
  data: {
    labels: bestLabels,
    datasets: [{
      label: 'Số lượng bán',
      data: bestData,
      backgroundColor: ['#36a2eb','#ff6384','#ffce56','#4bc0c0','#9966ff'],
      borderRadius: 8,
      borderSkipped: false,
      maxBarThickness: 32
    }]
  },
  options: {
    indexAxis: 'y',
    scales: {
      x: {
        beginAtZero: true,
        ticks: { color: '#333', font: { size: 14, weight: 'bold' } }
      },
      y: {
        ticks: { color: '#333', font: { size: 14, weight: 'bold' } }
      }
    },
    plugins: {
      legend: { display: false },
      tooltip: {
        callbacks: {
          label: ctx => ` ${ctx.parsed.x} lượt bán`
        }
      }
    }
  }
});

// Biểu đồ cột doanh thu tháng
new Chart(document.getElementById('barChart'), {
  type: 'bar',
  data: {
    labels: ['Th1','Th2','Th3','Th4','Th5','Th6','Th7','Th8','Th9','Th10','Th11','Th12'],
    datasets: [{
      label: 'Tổng doanh thu (VNĐ)',
      data: doanhthuThang,
      backgroundColor: 'rgba(255, 159, 64, 0.7)',
      borderRadius: 6
    }]
  },
  options: {
    scales: {
      y: {
        ticks: {
          callback: value => value.toLocaleString('vi-VN') + ' ₫'
        }
      }
    },
    plugins: {
      legend: { display: false }
    }
  }
});
</script>


<?php include(__DIR__ . '/../layout/footer.php'); ?>
