<div id="loading">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <!-- loading content here -->
            <div class="tp-preloader-content">
                <div class="tp-preloader-logo">
                    <div class="tp-preloader-circle">
                    <svg width="190" height="190" viewBox="0 0 380 380" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle stroke="#D9D9D9" cx="190" cy="190" r="180" stroke-width="6" stroke-linecap="round"></circle>
                        <circle stroke="#343265" cx="190" cy="190" r="180" stroke-width="6" stroke-linecap="round"></circle>
                    </svg>
                    </div>
                    <img src="assets/img/logo/preloader/preloader-icon.svg" alt="">
                </div>
                <h3 class="tp-preloader-title">گالری رهنما</h3>
                <p class="tp-preloader-subtitle">لطفا منتظر بمانید</p>
            </div>
        </div>
    </div>
</div>

<script>
    // مخفی‌کردن سریع پری‌لودر؛ به‌جای انتظار برای بارگذاری کامل همه‌ی تصاویر،
    // به‌محض آماده‌شدن DOM (یا حداکثر ۱.۲ ثانیه) صفحه نمایش داده می‌شود.
    (function () {
        function hidePreloader() {
            var el = document.getElementById('loading');
            if (!el || el.dataset.hidden) return;
            el.dataset.hidden = '1';
            el.style.transition = 'opacity .25s ease';
            el.style.opacity = '0';
            setTimeout(function () { el.style.display = 'none'; }, 260);
        }
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            hidePreloader();
        } else {
            document.addEventListener('DOMContentLoaded', hidePreloader);
        }
        // پشتیبان: در هر صورت بعد از ۱.۲ ثانیه مخفی شود
        setTimeout(hidePreloader, 1200);
    })();
</script>
