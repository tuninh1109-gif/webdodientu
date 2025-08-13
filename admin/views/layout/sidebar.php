<div class="d-flex">
  <nav class="bg-dark text-white p-3" style="width: 220px; height: 100vh;">
    <div class="admin-avatar">
      <img src="https://ui-avatars.com/api/?name=Admin&background=0d6efd&color=fff&size=128" alt="Admin Avatar">
      <div class="admin-name">Admin</div>
    </div>
    <h5 style="font-weight:600; color:#fff;">📋 Admin Menu</h5>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-white" href="index.php?page=danhgia_admin">
          <i class="bi bi-star-fill text-warning"></i> Quản lý đánh giá
        </a>
      </li>
      <?php
      include __DIR__ . '/../../../config/db.php';
      $menu_type = 'admin';
      $menu_sql = "SELECT * FROM menu_content WHERE type='$menu_type' ORDER BY position ASC, id ASC";
      $menu_result = mysqli_query($conn, $menu_sql);
      $menus = [];
      while ($m = mysqli_fetch_assoc($menu_result)) $menus[] = $m;
      function buildMenuTreeSidebar($menus, $parent_id = null) {
          $branch = [];
          foreach ($menus as $menu) {
              if ($menu['parent_id'] == $parent_id) {
                  $children = buildMenuTreeSidebar($menus, $menu['id']);
                  if ($children) $menu['children'] = $children;
                  $branch[] = $menu;
              }
          }
          return $branch;
      }
      $menu_tree = buildMenuTreeSidebar($menus);
      foreach ($menu_tree as $menu):
          if (!empty($menu['children'])): ?>
              <li class="nav-item dropdown">
                <a class="nav-link text-white dropdown-toggle" href="<?php echo htmlspecialchars($menu['url']); ?>" id="sidebar-menu-<?php echo $menu['id']; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php if ($menu['icon']): ?><i class="<?php echo htmlspecialchars($menu['icon']); ?>"></i> <?php endif; ?>
                  <?php echo htmlspecialchars($menu['label']); ?>
                </a>
                <ul class="dropdown-menu bg-dark border-0" aria-labelledby="sidebar-menu-<?php echo $menu['id']; ?>">
                  <?php foreach ($menu['children'] as $child): ?>
                    <li>
                      <a class="dropdown-item text-white bg-dark" href="<?php echo htmlspecialchars($child['url']); ?>">
                        <?php if ($child['icon']): ?><i class="<?php echo htmlspecialchars($child['icon']); ?>"></i> <?php endif; ?>
                        <?php echo htmlspecialchars($child['label']); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </li>
          <?php else: ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="<?php echo htmlspecialchars($menu['url']); ?>">
                  <?php if ($menu['icon']): ?><i class="<?php echo htmlspecialchars($menu['icon']); ?>"></i> <?php endif; ?>
                  <?php echo htmlspecialchars($menu['label']); ?>
                </a>
              </li>
          <?php endif;
      endforeach;
      ?>
      <li class="nav-item">
        <a class="nav-link text-danger" href="logout.php">🔓 Đăng xuất</a>
      </li>
    </ul>
    <!-- Gợi ý JS: Thêm class 'active' cho nav-link dựa vào URL hiện tại -->
    <script>
      const links = document.querySelectorAll('.nav-link');
      links.forEach(link => {
        if (window.location.href.includes(link.getAttribute('href'))) {
          link.classList.add('active');
        }
      });
    </script>
    </ul>
  </nav>

  <main class="p-4" style="flex-grow: 1;">
