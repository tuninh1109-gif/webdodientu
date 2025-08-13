// main.js - script cho trang chủ

// Hiệu ứng cuộn lên đầu trang
document.addEventListener('DOMContentLoaded', function() {
    const scrollBtn = document.getElementById('scrollTopBtn');
    if (scrollBtn) {
        scrollBtn.onclick = () => window.scrollTo({top: 0, behavior: 'smooth'});
    }

    // Hiệu ứng slider/banner (nếu có dùng thư viện ngoài thì import ở đây)
    // Ví dụ: tự động chuyển slide sau 3s
    let current = 0;
    const banners = document.querySelectorAll('.banner-slider .banner');
    if (banners.length > 1) {
        setInterval(() => {
            banners[current].classList.remove('active');
            current = (current + 1) % banners.length;
            banners[current].classList.add('active');
        }, 3000);
    }
});