// admin.js - script cho admin

document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar
    const toggleBtn = document.getElementById('sidebarToggle');
    if (toggleBtn) {
        toggleBtn.onclick = () => document.body.classList.toggle('sidebar-collapsed');
    }

    // Hiển thị thông báo tự động ẩn sau 3s
    const alerts = document.querySelectorAll('.alert-auto-hide');
    alerts.forEach(alert => {
        setTimeout(() => alert.style.display = 'none', 3000);
    });
});