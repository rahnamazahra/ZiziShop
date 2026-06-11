@extends('layouts.site.master')
@section('content')

         <section class="breadcrumb__area include-bg pt-95 pb-50">
            <div class="container">
               <div class="row">
                  <div class="col-xxl-12">
                     <div class="breadcrumb__content p-relative z-index-1">
                         <div class="breadcrumb__list">
                            <span><a href="#">صفحه اصلی</a></span>
                            <span>سبد خرید</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- breadcrumb area end -->

         <!-- cart area start -->
         <section class="tp-cart-area pb-120">
            <div class="container">
               <div class="row">
                  <div class="col-xl-9 col-lg-8">
                     <div class="tp-cart-list mb-25 ml-30">
                        <table class="table">
                           <thead>
                             <tr>
                               <th colspan="2" class="tp-cart-header-product">محصول</th>
                               <th class="tp-cart-header-price">قیمت</th>
                               <th class="tp-cart-header-quantity">کمیت</th>
                               <th></th>
                             </tr>
                           </thead>
                           <tbody>
                            @foreach($cart->products as $product)
                              <tr>
                                 <!-- img -->
                                 <td class="tp-cart-img"><a href="{{ route('products.show', $product->slug) }}"> <img src="{{ $product->poster_url }}" style="width:70px;height:70px;object-fit:cover;border-radius:8px;" alt="{{ $product->name }}"></a></td>
                                 <!-- title -->
                                 <td class="tp-cart-title"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></td>
                                 <!-- price -->
                                 <td class="tp-cart-price"><span>{{ number_format($cart->lineUnitPrice($product)) }} تومان</span></td>
                                 <!-- quantity -->
                                 <td class="tp-cart-quantity">
                                    <div class="tp-product-quantity mt-10 mb-10">
                                       <span class="tp-cart-minus">
                                          <svg width="10" height="2" viewBox="0 0 10 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M1 1H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                       </span>
                                       <input class="tp-cart-input" type="text" value="{{  $product->pivot->count }}">
                                       <span class="tp-cart-plus">
                                          <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M5 1V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                             <path d="M1 5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                       </span>
                                    </div>
                                 </td>
                                 <!-- action -->
                                 <td class="tp-cart-action">
                                    <form action="{{ route('remove.to.cart',['product' => $product]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="tp-cart-action-btn">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.53033 1.53033C9.82322 1.23744 9.82322 0.762563 9.53033 0.46967C9.23744 0.176777 8.76256 0.176777 8.46967 0.46967L5 3.93934L1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L3.93934 5L0.46967 8.46967C0.176777 8.76256 0.176777 9.23744 0.46967 9.53033C0.762563 9.82322 1.23744 9.82322 1.53033 9.53033L5 6.06066L8.46967 9.53033C8.76256 9.82322 9.23744 9.82322 9.53033 9.53033C9.82322 9.23744 9.82322 8.76256 9.53033 8.46967L6.06066 5L9.53033 1.53033Z" fill="currentColor"/>
                                            </svg>
                                            <span>حذف</span>
                                        </button>
                                    </form>
                                 </td>
                              </tr>
                            @endforeach

                           </tbody>
                         </table>
                     </div>

                     <div class="tp-cart-bottom">
                        <div class="row align-items-end">
                           <div class="col-xl-6 col-md-8">
                              <div class="tp-cart-coupon">

                                <form action="{{ route('vouch') }}" method="post">
                                    @csrf
                                    <div class="tp-cart-coupon-input-box">
                                        <label>کد کوپن:</label>
                                        <div class="tp-cart-coupon-input d-flex align-items-center">
                                            <input type="text" name="voucher" placeholder="کد کوپن را وارد کنید">
                                            <button type="submit">اعمال</button>
                                        </div>
                                    </div>
                                </form>

                              </div>
                           </div>

                           <div class="col-xl-6 col-md-4">
                              <div class="tp-cart-update text-md-start">
                                 <button type="button" class="tp-cart-update-btn">به روز رسانی سبد خرید</button>
                               </div>
                            </div>

                         </div>
                      </div>
                   </div>

                   <div class="col-xl-3 col-lg-4 col-md-6">
                      <div class="tp-cart-checkout-wrapper">
                         <div class="tp-cart-checkout-top d-flex align-items-center justify-content-between">
                            <span class="tp-cart-checkout-top-title">مجموع فرعی</span>
                            <span class="tp-cart-checkout-top-price">{{ $cart->raw_total }}</span>
                         </div>
                         <div class="tp-cart-checkout-shipping">
                            <h4 class="tp-cart-checkout-shipping-title">ارسال</h4>

                            <div class="tp-cart-checkout-shipping-option-wrapper">
                               <div class="tp-cart-checkout-shipping-option">
                                  <input id="flat_rate" type="radio" name="shipping">
                                  <label for="flat_rate">نرخ ثابت: <span>20 تومان</span></label>
                               </div>
                               <div class="tp-cart-checkout-shipping-option">
                                  <input id="local_pickup" type="radio" name="shipping">
                                  <label for="local_pickup"> تحویل محلی: <span> 25 تومان</span></label>
                               </div>
                               <div class="tp-cart-checkout-shipping-option">
                                  <input id="free_shipping" type="radio" name="shipping">
                                  <label for="free_shipping">ارسال رایگان</label>
                               </div>
                            </div>
                         </div>
                           @if ($cart->voucher)
                                <span>کد کوپن {{ $cart->voucher->code }} -  تخفیف {{ $cart->voucher->discount_percent }}%</span>
                            @endif
                         <div class="tp-cart-checkout-total d-flex align-items-center justify-content-between">
                            <span>مجموع</span>
                            <span>{{ $cart->total }}</span>
                         </div>
                         <div class="gr-checkout-address mt-20">
                            <h4 class="tp-cart-checkout-shipping-title">اطلاعات ارسال</h4>

                            @auth('web')
                                @if($cart->address)
                                    <div class="gr-addr-current">آدرس انتخاب‌شده: {{ $cart->address->receiver }} — {{ optional($cart->address->city)->name }}</div>
                                @endif

                                @if($addresses->count())
                                    <form method="post" id="grSelectAddrForm" class="mb-15">
                                        @csrf
                                        <select class="form-control mb-10" onchange="document.getElementById('grSelectAddrForm').action='{{ url('address') }}/'+this.value+'/select';">
                                            <option value="">انتخاب آدرس قبلی...</option>
                                            @foreach($addresses as $a)
                                                <option value="{{ $a->id }}" {{ $cart->address_id == $a->id ? 'selected' : '' }}>{{ $a->receiver }} — {{ \Illuminate\Support\Str::limit($a->body, 30) }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="gr-card-add-btn" style="width:100%;">انتخاب این آدرس</button>
                                    </form>
                                @endif

                                <details class="gr-addr-new" {{ $addresses->count() ? '' : 'open' }}>
                                    <summary>افزودن آدرس جدید</summary>
                                    <form method="post" action="{{ route('address.store') }}" class="mt-10">
                                        @csrf
                                        <input name="receiver" class="form-control mb-10" placeholder="نام گیرنده" value="{{ auth('web')->user()->name }}" required>
                                        <input name="mobile" class="form-control mb-10" placeholder="موبایل" value="{{ auth('web')->user()->mobile }}" required>
                                        <input name="national_code" class="form-control mb-10" placeholder="کد ملی (۱۰ رقم)" required>
                                        <input name="postal_code" class="form-control mb-10" placeholder="کد پستی" required>
                                        <select name="city_id" class="form-control mb-10" required>
                                            <option value="">انتخاب شهر</option>
                                            @foreach($provinces as $p)
                                                <optgroup label="{{ $p->name }}">
                                                    @foreach($p->cities as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <label style="font-size:13px;color:#343265;font-weight:600;display:block;margin-bottom:4px;">تاریخ تولد</label>
                                        <input type="date" name="birthday" class="form-control mb-2">
                                        <div style="font-size:12px;color:#1f9d55;background:#eaf7ef;border-radius:8px;padding:8px 10px;margin-bottom:10px;line-height:1.9;">
                                            🎁 با ثبت تاریخ تولد، روز تولدتان یک کوپن تخفیف ۲۰۰٬۰۰۰ تومانی (اعتبار ۱۰ روزه) برایتان پیامک می‌شود.
                                        </div>
                                        <textarea name="body" class="form-control mb-10" rows="2" placeholder="آدرس کامل" required></textarea>
                                        <button type="submit" class="gr-card-add-btn" style="width:100%;">ذخیره و انتخاب</button>
                                    </form>
                                </details>
                            @else
                                <p>برای تکمیل خرید ابتدا <a href="{{ route('auth.login.form') }}">وارد شوید</a>.</p>
                            @endauth
                         </div>

                         <div class="tp-cart-checkout-proceed">
                            <form method="post" action="{{ route('checkout')}}" class="mt-16 flex justify-center">
                            @csrf
                                <button type="submit" href="checkout.html" class="tp-cart-checkout-btn w-100">رفتن به پرداخت</button>
                            </form>
                         </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- cart area end -->
@endsection
