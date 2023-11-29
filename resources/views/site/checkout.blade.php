@extends('layouts.site.master')
@section('content')

         <!-- breadcrumb area start -->
         <section class="breadcrumb__area include-bg pt-95 pb-50" data-bg-color="#EFF1F5">
            <div class="container">
               <div class="row">
                  <div class="col-xxl-12">
                     <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title">تسویه حساب</h3>
                         <div class="breadcrumb__list">
                            <span><a href="#">صفحه اصلی</a></span>
                            <span>تسویه حساب</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- breadcrumb area end -->

         <!-- checkout area start -->
         <section class="tp-checkout-area pb-120" data-bg-color="#EFF1F5">
            <div class="container">
               <div class="row">
                  <div class="col-xl-7 col-lg-7">
                     <div class="tp-checkout-verify">
                        <div class="tp-checkout-verify-item">
                           <p class="tp-checkout-verify-reveal">مشتری بازگشتی؟ <button type="button" class="tp-checkout-login-form-reveal-btn">برای ورود اینجا را کلیک کنید</button></p>

                           <div id="tpReturnCustomerLoginForm" class="tp-return-customer">
                              <form action="#">

                                 <div class="tp-return-customer-input">
                                    <label>ایمیل</label>
                                    <input type="text" placeholder="ایمیل شما">
                                 </div>
                                 <div class="tp-return-customer-input">
                                    <label>رمز عبور</label>
                                    <input type="password" placeholder="Password">
                                 </div>

                                 <div class="tp-return-customer-suggetions d-sm-flex align-items-center justify-content-between mb-20">
                                    <div class="tp-return-customer-remeber">
                                       <input id="remeber" type="checkbox">
                                       <label for="remeber">من را به خاطر بسپار</label>
                                    </div>
                                    <div class="tp-return-customer-forgot">
                                       <a href="forgot.html">گذرواژه را فراموش کرده‌اید؟</a>
                                    </div>
                                 </div>
                                 <button type="submit" class="tp-return-customer-btn tp-checkout-btn">ورود به سیستم</button>
                              </form>
                           </div>
                        </div>
                        <div class="tp-checkout-verify-item">
                           <p class="tp-checkout-verify-reveal">کوپن دارید؟ <button type="button" class="tp-checkout-coupon-form-reveal-btn">برای وارد کردن کد خود اینجا را کلیک کنید</button></p>

                           <div id="tpCheckoutCouponForm" class="tp-return-customer">
                              <form action="#">
                                 <div class="tp-return-customer-input">
                                    <label>کد کوپن:</label>
                                    <input type="text" placeholder="کوپن">
                                 </div>
                                 <button type="submit" class="tp-return-customer-btn tp-checkout-btn">اعمال</button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-7">
                     <div class="tp-checkout-bill-area">
                        <h3 class="tp-checkout-bill-title">جزئیات صورتحساب</h3>

                        <div class="tp-checkout-bill-form">
                           <form action="#">
                              <div class="tp-checkout-bill-inner">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="tp-checkout-input">
                                          <label>نام <span>*</span></label>
                                          <input type="text" placeholder="نام">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="tp-checkout-input">
                                          <label>نام خانوادگی <span>*</span></label>
                                          <input type="text" placeholder="نام خانوادگی">
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="tp-checkout-input">
                                          <label>نام شرکت (اختیاری)</label>
                                           <input type="text" placeholder="نام شرکت">
                                        </div>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="tp-checkout-input">
                                           <label>کشور / منطقه </label>
                                           <input type="text" placeholder="ایالات متحده (ایالات متحده)">
                                        </div>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="tp-checkout-input">
                                           <label>آدرس خیابان</label>
                                           <input type="text" placeholder="شماره خانه و نام خیابان">
                                        </div>

                                        <div class="tp-checkout-input">
                                           <input type="text" placeholder="آپارتمان، سوئیت، واحد و غیره (اختیاری)">
                                        </div>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="tp-checkout-input">
                                           <label>شهرک / شهر</label>
                                           <input type="text" placeholder="شهرک">
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="tp-checkout-input">
                                           <label>ایالت / شهرستان</label>
                                           <select>
                                              <option>نیویورک ایالات متحده</option>
                                              <option>برلین آلمان</option>
                                              <option>پاریس فرانسه</option>
                                              <option>توکیو ژاپن</option>
                                           </select>
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="tp-checkout-input">
                                           <label>کدپستی پستی</label>
                                           <input type="text" placeholder="کدپستی">
                                        </div>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="tp-checkout-input">
                                           <label>تلفن <span>*</span></label>
                                           <input type="text" placeholder="تلفن">
                                        </div>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="tp-checkout-input">
                                           <label>آدرس ایمیل <span>*</span></label>
                                           <input type="email" placeholder="ایمیل">
                                        </div>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="tp-checkout-option-wrapper">
                                           <div class="tp-checkout-option">
                                              <input id="create_free_account" type="checkbox">
                                              <label for="create_free_account">یک حساب ایجاد کنید؟</label>
                                           </div>
                                           <div class="tp-checkout-option">
                                              <input id="ship_to_diff_address" type="checkbox">
                                              <label for="ship_to_diff_address">به آدرس دیگری ارسال شود؟</label>
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="tp-checkout-input">
                                           <label>یادداشت‌ها را سفارش دهید (اختیاری)</label>
                                          <textarea placeholder="نکاتی در مورد سفارش شما، به عنوان مثال یادداشت های ویژه برای تحویل"></textarea>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-5">
                     <!-- checkout place order -->
                     <div class="tp-checkout-place white-bg">
                        <h3 class="tp-checkout-place-title">سفارش شما</h3>

                        <div class="tp-order-info-list">
                           <ul>

                              <!-- header -->
                              <li class="tp-order-info-list-header">
                                 <h4>محصول</h4>
                                  <h4>مجموع</h4>
                              </li>

                              <!-- item list -->
                              <li class="tp-order-info-list-desc">
                                 <p>شیائومی ردمی نوت 8<span style="display: inline flow-root list-item;"> x </span> 2</p>
                                  <span>274 تومان</span>
                               </li>
                               <li class="tp-order-info-list-desc">
                                  <p>صندلی چندگانه اداری <span style="display: inline flow-root list-item;"> x </span> 1</p>
                                  <span>74 تومان</span>
                               </li>
                               <li class="tp-order-info-list-desc">
                                  <p>اپل واچ سری 6<span style="display: inline flow-root list-item;"> x </span> 3</p>
                                  <span>362 تومان</span>
                               </li>
                               <li class="tp-order-info-list-desc">
                                  <p>مجموعه مردانه<span style="display: inline flow-root list-item;"> x </span> 1</p>
                                  <span>145 تومان</span>
                              </li>

                              <!-- subtotal -->
                              <li class="tp-order-info-list-subtotal">
                                 <span>مجموع فرعی</span>
                                  <span>507 تومان</span>
                              </li>

                              <!-- shipping -->
                              <li class="tp-order-info-list-shipping">
                                 <span>حمل و نقل</span>
                                  <div class="tp-order-info-list-shipping-item d-flex flex-column align-items-end">
                                     <span>
                                        <input id="flat_rate" type="radio" name="shipping">
                                        <label for="flat_rate">نرخ ثابت: <span>20 تومان</span></label>
                                     </span>
                                     <span>
                                        <input id="local_pickup" type="radio" name="shipping">
                                        <label for="local_pickup"> تحویل محلی: <span>25 تومان</span></label>
                                     </span>
                                     <span>
                                        <input id="free_shipping" type="radio" name="shipping">
                                        <label for="free_shipping">ارسال رایگان</label>
                                    </span>
                                 </div>
                              </li>

                              <!-- total -->
                              <li class="tp-order-info-list-total">
                                 <span>مجموع</span>
                                 <span>1,476 تومان</span>
                              </li>
                           </ul>
                        </div>
                        <div class="tp-checkout-payment">
                           <div class="tp-checkout-payment-item">
                              <input type="radio" id="back_transfer" name="payment">
                              <label for="back_transfer" data-bs-toggle="direct-bank-transfer">انتقال مستقیم بانکی</label>
                              <div class="tp-checkout-payment-desc direct-bank-transfer">
                                 <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است</p>
                              </div>
                           </div>
                           <div class="tp-checkout-payment-item">
                              <input type="radio" id="cheque_payment" name="payment">
                              <label for="cheque_payment">پرداخت را چک کنید</label>
                              <div class="tp-checkout-payment-desc cheque-payment">
                                 <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است</p>
                              </div>
                           </div>
                           <div class="tp-checkout-payment-item">
                              <input type="radio" id="cod" name="payment">
                              <label for="cod">پرداخت نقدی هنگام تحویل</label>
                              <div class="tp-checkout-payment-desc cash-on-delivery">
                                 <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است</p>
                              </div>
                           </div>
                           <div class="tp-checkout-payment-item paypal-payment">
                              <input type="radio" id="paypal" name="payment">
                              <label for="paypal">پی پال <img src="assets/img/icon/payment-option.png" alt=""> <a href="#">PayPal چیست؟</a></label>
                           </div>
                        </div>
                        <div class="tp-checkout-agree">
                           <div class="tp-checkout-option">
                              <input id="read_all" type="checkbox">
                              <label for="read_all">من وب سایت را خوانده ام و با آن موافقم.</label>
                           </div>
                        </div>
                        <div class="tp-checkout-btn-wrapper">
                           <a href="#" class="tp-checkout-btn w-100">ثبت سفارش</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- checkout area end -->
@endsection




