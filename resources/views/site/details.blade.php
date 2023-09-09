@extends('layouts.site')
@section('customStyle')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/exzoom/jquery.exzoom.css') }}">

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!--<script src="js/jquery-1.9.1.min.js"></script>-->
    <script src="https://pagead2.googlesyndication.com/pagead/managed/js/adsense/m202308310101/reactive_library_fy2021.js"></script><script src="https://partner.googleadservices.com/gampad/cookie.js?domain=www.jqueryscript.net&amp;callback=_gfp_s_&amp;client=ca-pub-2783044520727903&amp;cookie=ID%3D18156b191cde5a21-22f67eb945e00033%3AT%3D1690795634%3ART%3D1694092756%3AS%3DALNI_MYhmBP57z2byax_WT-uZEpYOn5-dQ&amp;gpic=UID%3D00000c74fcd0d1ca%3AT%3D1690795634%3ART%3D1694092756%3AS%3DALNI_Mb7Mh3RiI30R6I7bPLiIUqYsgDKgQ"></script><script src="https://pagead2.googlesyndication.com/pagead/managed/js/adsense/m202308310101/show_ads_impl_fy2021.js" id="google_shimpl"></script><script type="text/javascript" async="" src="https://ssl.google-analytics.com/ga.js"></script><script src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="jquery.exzoom.js"></script>
    <link href="jquery.exzoom.css" rel="stylesheet" type="text/css">
    <style>
    #exzoom {
        width: 400px;
        /*height: 400px;*/
    }
    .container { margin: 150px auto; max-width: 960px; }
    .hidden { display: none; }
</style>
@endsection
@section('content')
<div class="flex container mx-auto">
    <div class="w-1/2">
        <h1>نیمتنه شلوار بگ</h1>
        <div class="rating">
            @for ($i = 1; $i <= 5; $i++)
                <i class="bx bx-star text-lg text-color4"></i>
            @endfor
        </div>
        <h3>678,000  تومان</h3>
        <p>گزینه‌ی سایز و رنگ را انتخاب کنید تا عکسِ مربوط به همان رنگ به شما نمایش داده شود</p>
        <div>
            <div class="my-5">رنگ‌:</div>
            <div class="flex">
                <button class="ml-1 border p-4">سبز</button>
                <button class="ml-1 border p-4">آبی</button>
            </div>
        </div>
        <div class="woocommerce-variation-add-to-cart variations_button woocommerce-variation-add-to-cart-disabled">

            <span>تعداد</span>
            <div class="quantity">
                <input type="button" value="-" class="minus">
                <input type="number" id="quantity_64f883ccd5889" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="تعداد" size="4" placeholder="" inputmode="numeric">
                <input type="button" value="+" class="plus">
            </div>

            <button type="submit" class="single_add_to_cart_button button alt disabled wc-variation-selection-needed">افزودن به سبد خرید</button>
            <input type="hidden" name="add-to-cart" value="176518">
            <input type="hidden" name="product_id" value="176518">
            <input type="hidden" name="variation_id" class="variation_id" value="0">
        </div>
        <div>
            <a class="flex items-center" href="#">
                <i class="bx bx-heart text-xl"></i>
                <span class="ml-2"> افزودن به علاقه مندی</span>
            </a>
        </div>
        <div>
            <input type="checkbox">
            <span>وقتی این مدل موجود شد بهت اطلاع بدم؟</span>
            <div>
                <form>
                    <input type="text" placeholder="شماره موبایل" name="">
                    <input type="submit" value="ثبت">
                </form>
            </div>
        </div>
        <hr>
        <div>
            <div>
                <span class="text-color3"> شناسه محصول: </span>
                <span class="text-color1">312</span>
            </div>
            <div>
                <span class="text-color3"> دسته: </span>
                <span class="text-color1">بلوز</span>
            </div>
            <div>
                <span class="text-color3"> دسته: </span>
                <span class="text-color1">بلوز</span>
            </div>
             <div>
                <span class="text-color3"> دسته: </span>
                <span class="text-color1">بلوز</span>
            </div>
        </div>

    </div>
    <div class="w-1/2">
       <div class="container">
<h1>jQuery exzoom: Product Carousel Example</h1>
<div class="exzoom" id="exzoom" style="">
    <div class="exzoom_img_box" style="width: 400px; height: 400px;">

    <div class="exzoom_img_ul_outer" style="width: 400px; height: 400px;"><ul class="exzoom_img_ul" style="width: 3200px; left: 0px;">
            <li style="width: 400px;"><img src="https://picsum.photos/270/270/?random" style="margin-top: 0px; width: 400px;"></li>
            <li style="width: 400px;"><img src="https://picsum.photos/320/320/?random" style="margin-top: 0px; width: 400px;"></li>
            <li style="width: 400px;"><img src="https://picsum.photos/600/600/?random" style="margin-top: 0px; width: 400px;"></li>
            <li style="width: 400px;"><img src="https://picsum.photos/500/500/?random" style="margin-top: 0px; width: 400px;"></li>
            <li style="width: 400px;"><img src="https://picsum.photos/700/700/?random" style="margin-top: 0px; width: 400px;"></li>
            <li style="width: 400px;"><img src="https://picsum.photos/310/310/?random" style="margin-top: 0px; width: 400px;"></li>
            <li style="width: 400px;"><img src="https://picsum.photos/410/410/?random" style="margin-top: 0px; width: 400px;"></li>
            <li style="width: 400px;"><img src="https://picsum.photos/400/400/?random" style="margin-top: 0px; width: 400px;"></li>
        </ul></div>
<div class="exzoom_zoom_outer" style="width: 400px; height: 400px; top: 0px; left: 0px; position: relative;">
    <span class="exzoom_zoom" style="width: 200px; height: 200px; display: none; left: 40.4px; top: 122.963px;"></span>
</div>
<p class="exzoom_preview" style="width: 400px; height: 400px; left: 405px; display: none;">
    <img class="exzoom_preview_img" src="https://picsum.photos/270/270/?random" style="width: 800px; height: 800px; left: -80.4768px; top: -244.941px;">
</p>
            </div>
    <div class="exzoom_nav" style="height: 62px; width: 373.2px;"><p class="exzoom_nav_inner" style="width: 552px; left: 0px;"><span class="current" style="margin-left: 7px; width: 60px; height: 60px;"><img src="https://picsum.photos/270/270/?random" width="60" height="60"></span><span class="" style="margin-left: 7px; width: 60px; height: 60px;"><img src="https://picsum.photos/320/320/?random" width="60" height="60"></span><span class="" style="margin-left: 7px; width: 60px; height: 60px;"><img src="https://picsum.photos/600/600/?random" width="60" height="60"></span><span class="" style="margin-left: 7px; width: 60px; height: 60px;"><img src="https://picsum.photos/500/500/?random" width="60" height="60"></span><span class="" style="margin-left: 7px; width: 60px; height: 60px;"><img src="https://picsum.photos/700/700/?random" width="60" height="60"></span><span class="" style="margin-left: 7px; width: 60px; height: 60px;"><img src="https://picsum.photos/310/310/?random" width="60" height="60"></span><span style="margin-left: 7px; width: 60px; height: 60px;"><img src="https://picsum.photos/410/410/?random" width="60" height="60"></span><span style="margin-left: 7px; width: 60px; height: 60px;"><img src="https://picsum.photos/400/400/?random" width="60" height="60"></span></p></div>
    <p class="exzoom_btn">
        <a href="javascript:void(0);" class="exzoom_prev_btn"> &lt; </a>
        <a href="javascript:void(0);" class="exzoom_next_btn"> &gt; </a>
    </p>
</div>
</div>
    </div>
</div>
@endsection
@section('customScript')
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="{{ asset('assets/exzoom/jquery.exzoom.js') }}"></script>
<script>
    $(function(){
        $("#exzoom").exzoom({
            "navWidth": 60,
            "navHeight": 60,
            "navItemNum": 5,
            "navItemMargin": 7,
            "navBorder": 1,
            "autoPlay": false,
            "autoPlayTimeout": 2000
        });
    });
@endsection
