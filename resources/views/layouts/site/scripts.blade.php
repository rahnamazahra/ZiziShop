<script src="{{ asset('site/assets/js/vendor/jquery.js') }}"></script>
<script src="{{ asset('site/assets/js/vendor/waypoints.js') }}"></script>
<script src="{{ asset('site/assets/js/bootstrap-bundle.js') }}"></script>
<script src="{{ asset('site/assets/js/meanmenu.js') }}"></script>
<script src="{{ asset('site/assets/js/swiper-bundle.js') }}"></script>
<script src="{{ asset('site/assets/js/slick.js') }}"></script>
<script src="{{ asset('site/assets/js/range-slider.js') }}"></script>
<script src="{{ asset('site/assets/js/magnific-popup.js') }}"></script>
<script src="{{ asset('site/assets/js/nice-select.js') }}"></script>
<script src="{{ asset('site/assets/js/purecounter.js') }}"></script>
<script src="{{ asset('site/assets/js/countdown.js') }}"></script>
<script src="{{ asset('site/assets/js/wow.js') }}"></script>
<script src="{{ asset('site/assets/js/isotope-pkgd.js') }}"></script>
<script src="{{ asset('site/assets/js/imagesloaded-pkgd.js') }}"></script>
<script src="{{ asset('site/assets/js/ajax-form.js') }}"></script>
<script src="{{ asset('site/assets/js/main.js') }}"></script>

<script>
(function ($) {
    "use strict";

    var csrf     = $('meta[name="csrf-token"]').attr('content');
    var loginUrl = $('meta[name="login-url"]').attr('content');
    var isAuth   = $('meta[name="is-auth"]').attr('content') === '1';

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' } });

    function applyCart(data) {
        if (data && typeof data.count !== 'undefined') {
            $('.js-cart-badge').text(data.count);
        }
        if (data && typeof data.html !== 'undefined') {
            $('.js-cartmini-body').html(data.html);
        }
    }

    function openMiniCart() {
        $('.cartmini__area').addClass('cartmini-opened');
        $('.body-overlay').addClass('opened');
    }

    // ---- Add to cart (delegated, matched by URL so every add-to-cart link works) ----
    $(document).on('click', 'a[href*="/add-to-cart/"], .js-add-to-cart', function (e) {
        var url = $(this).attr('href');
        if (!url || url === '#') return;
        e.preventDefault();
        e.stopPropagation();

        var $btn = $(this);
        $.get(url)
            .done(function (data) {
                applyCart(data);
                openMiniCart();
                // feedback so the user knows the product was added
                if ($btn.hasClass('tp-product-details-add-to-cart-btn')) {
                    var original = $btn.data('label') || $btn.text();
                    $btn.data('label', original);
                    $btn.text('✓ به سبد خرید اضافه شد');
                    setTimeout(function () { $btn.text($btn.data('label')); }, 2000);
                } else {
                    // icon cards: mark as added (green check styling via .in-cart)
                    $btn.addClass('in-cart');
                }
            })
            .fail(function (xhr) {
                if (xhr.status === 401 || xhr.status === 419) window.location.href = loginUrl;
            });
        return false;
    });

    // ---- Quantity +/- and remove inside the mini-cart ----
    $(document).on('click', '.js-cart-increase', function () {
        $.post('/cart/increase/' + $(this).data('id')).done(applyCart);
    });
    $(document).on('click', '.js-cart-decrease', function () {
        $.post('/cart/decrease/' + $(this).data('id')).done(applyCart);
    });
    $(document).on('click', '.js-cart-remove', function () {
        $.ajax({ url: '/remove-from-cart/' + $(this).data('id'), method: 'POST', data: { _method: 'DELETE' } })
            .done(applyCart);
    });

    // ---- حذف مودال Quick-View: دکمه‌ی «مشاهده» به صفحه‌ی جزئیات برود ----
    $('.tp-product-quick-view-btn').removeAttr('data-bs-toggle').removeAttr('data-bs-target');
    $(document).on('click', '.tp-product-quick-view-btn', function (e) {
        e.preventDefault();
        var $card = $(this).closest('.tp-product-item-2, .gr-card, .tp-featured-item, .tp-product-week-item, [class*="product-item"]');
        var url = $card.find('a').filter(function () {
            return /\/products\/.+\/detail/.test(this.href || '');
        }).first().attr('href');
        if (url) { window.location.href = url; }
    });

    // ---- منوی دسته‌بندی موبایل به‌صورت پیش‌فرض باز باشد ----
    setTimeout(function () {
        $('.tp-category-mobile-menu nav').show();
        $('.tp-offcanvas-category-toggle').addClass('active');
    }, 600);

    // ---- نمایش نتایج دسته‌بندی روی تب‌های صفحه‌ی اصلی ----
    function grActivateCatTab(id) {
        var btn = document.getElementById('nav-' + id + '-tab');
        if (btn) {
            btn.click();
            var sec = btn.closest('section');
            if (sec) {
                window.scrollTo({ top: sec.getBoundingClientRect().top + window.pageYOffset - 120, behavior: 'smooth' });
            }
            return true;
        }
        return false;
    }
    if (location.hash && location.hash.indexOf('#nav-') === 0) {
        setTimeout(function () { grActivateCatTab(location.hash.replace('#nav-', '')); }, 350);
    }
    $(document).on('click', '.gr-cat-link', function (e) {
        var id = $(this).data('cat');
        if (document.getElementById('nav-' + id + '-tab')) {
            e.preventDefault();
            grActivateCatTab(id);
            history.replaceState(null, '', '#nav-' + id);
        }
    });

    // ---- انتخابگر تعداد +/- در صفحه‌ی جزئیات محصول و سبد ----
    $(document).on('click', '.tp-cart-plus', function () {
        var $input = $(this).parent().find('.tp-cart-input');
        var v = parseInt($input.val(), 10) || 1;
        $input.val(v + 1).trigger('change');
    });
    $(document).on('click', '.tp-cart-minus', function () {
        var $input = $(this).parent().find('.tp-cart-input');
        var v = parseInt($input.val(), 10) || 1;
        if (v > 1) { $input.val(v - 1).trigger('change'); }
    });

    // ---- صفحه‌بندی سمت کلاینت («نمایش بیشتر») برای هر تب محصولات ----
    var GR_PAGE = 8;
    $('.tab-pane').each(function () {
        var $pane = $(this);
        var $items = $pane.find('.infinite-item');
        if ($items.length <= GR_PAGE) { return; }
        $items.slice(GR_PAGE).hide().addClass('gr-more-hidden');
        var $wrap = $('<div class="text-center mt-30 gr-load-more-wrap"><button type="button" class="gr-load-more">نمایش بیشتر</button></div>');
        $pane.append($wrap);
        $wrap.find('.gr-load-more').on('click', function () {
            $pane.find('.infinite-item.gr-more-hidden').slice(0, GR_PAGE).fadeIn().removeClass('gr-more-hidden');
            if ($pane.find('.infinite-item.gr-more-hidden').length === 0) { $wrap.remove(); }
        });
    });

})(jQuery);
</script>

@vite('resources/js/app.js')
