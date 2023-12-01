@extends('layouts.site.master')
@section('content')

    <section class="tp-product-area pb-90">
        <div class="container">

            <div class="row mt-50">
                <div class="col-xl-12">
                    <div class="tp-product-tab-2 tp-tab mb-50 text-center">
                        <nav>
                            <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">

                                <button class="nav-link active" id="nav-allCollection-tab" data-bs-toggle="tab" data-bs-target="#nav-allCollection" type="button" role="tab" aria-controls="nav-allCollection" aria-selected="true">
                                    همه مجموعه
                                    <span class="tp-product-tab-tooltip">{{ $categories->sum('products_count') }}</span>
                                </button>

                                @foreach($categories as $category)
                                    <button class="nav-link" id="nav-{{ $category->id }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $category->id }}" type="button" role="tab" aria-controls="nav-{{ $category->id }}" aria-selected="false">
                                        {{ $category->name }}
                                        <span class="tp-product-tab-tooltip">{{ $category->products_count }}</span>
                                    </button>
                                @endforeach

                            </div>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="tab-content" id="nav-tabContent">

                        <div class="tab-pane fade show active" id="nav-allCollection" role="tabpanel" aria-labelledby="nav-allCollection-tab" tabindex="0">
                            <div class="row">
                                @forelse($products as $product)
                                    <div class="col-xl-3 col-md-6 col-sm-6 infinite-item">
                                        <div class="tp-product-item-2 mb-40">
                                            <div class="tp-product-thumb-2 p-relative z-index-1 fix w-img">

                                                <a href="{{ route('products.show', ['product' => $product]) }}">
                                                    {{--  <img src="{{ $product->images()->first()->path }}" alt="">  --}}
                                                    <img src="{{('site/assets/img/product/2/prodcut-1.jpg') }}" alt="">
                                                </a>

                                                <div class="tp-product-action-2 tp-product-action-blackStyle">
                                                    <div class="tp-product-action-item-2 d-flex flex-column">
                                                        <a href="{{ route('add.to.cart', ['product' => $product]) }}" class="tp-product-action-btn-2 tp-product-add-cart-btn">
                                                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.34706 4.53799L3.85961 10.6239C3.89701 11.0923 4.28036 11.4436 4.74871 11.4436H4.75212H14.0265H14.0282C14.4711 11.4436 14.8493 11.1144 14.9122 10.6774L15.7197 5.11162C15.7384 4.97924 15.7053 4.84687 15.6245 4.73995C15.5446 4.63218 15.4273 4.5626 15.2947 4.54393C15.1171 4.55072 7.74498 4.54054 3.34706 4.53799ZM4.74722 12.7162C3.62777 12.7162 2.68001 11.8438 2.58906 10.728L1.81046 1.4837L0.529505 1.26308C0.181854 1.20198 -0.0501969 0.873587 0.00930333 0.526523C0.0705036 0.17946 0.406255 -0.0462578 0.746256 0.00805037L2.51426 0.313534C2.79901 0.363599 3.01576 0.5995 3.04042 0.888012L3.24017 3.26484C15.3748 3.26993 15.4139 3.27587 15.4726 3.28266C15.946 3.3514 16.3625 3.59833 16.6464 3.97849C16.9303 4.35779 17.0493 4.82535 16.9813 5.29376L16.1747 10.8586C16.0225 11.9177 15.1011 12.7162 14.0301 12.7162H14.0259H4.75402H4.74722Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6629 7.67446H10.3067C9.95394 7.67446 9.66919 7.38934 9.66919 7.03804C9.66919 6.68673 9.95394 6.40161 10.3067 6.40161H12.6629C13.0148 6.40161 13.3004 6.68673 13.3004 7.03804C13.3004 7.38934 13.0148 7.67446 12.6629 7.67446Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.38171 15.0212C4.63756 15.0212 4.84411 15.2278 4.84411 15.4836C4.84411 15.7395 4.63756 15.9469 4.38171 15.9469C4.12501 15.9469 3.91846 15.7395 3.91846 15.4836C3.91846 15.2278 4.12501 15.0212 4.38171 15.0212Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.38082 15.3091C4.28477 15.3091 4.20657 15.3873 4.20657 15.4833C4.20657 15.6763 4.55592 15.6763 4.55592 15.4833C4.55592 15.3873 4.47687 15.3091 4.38082 15.3091ZM4.38067 16.5815C3.77376 16.5815 3.28076 16.0884 3.28076 15.4826C3.28076 14.8767 3.77376 14.3845 4.38067 14.3845C4.98757 14.3845 5.48142 14.8767 5.48142 15.4826C5.48142 16.0884 4.98757 16.5815 4.38067 16.5815Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9701 15.0212C14.2259 15.0212 14.4333 15.2278 14.4333 15.4836C14.4333 15.7395 14.2259 15.9469 13.9701 15.9469C13.7134 15.9469 13.5068 15.7395 13.5068 15.4836C13.5068 15.2278 13.7134 15.0212 13.9701 15.0212Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9692 15.3092C13.874 15.3092 13.7958 15.3874 13.7958 15.4835C13.7966 15.6781 14.1451 15.6764 14.1443 15.4835C14.1443 15.3874 14.0652 15.3092 13.9692 15.3092ZM13.969 16.5815C13.3621 16.5815 12.8691 16.0884 12.8691 15.4826C12.8691 14.8767 13.3621 14.3845 13.969 14.3845C14.5768 14.3845 15.0706 14.8767 15.0706 15.4826C15.0706 16.0884 14.5768 16.5815 13.969 16.5815Z" fill="currentColor"/>
                                                            </svg>
                                                            <span class="tp-product-tooltip tp-product-tooltip-right">به سبد خرید اضافه کنید</span>
                                                        </a>

                                                        <button type="button" class="tp-product-action-btn-2 tp-product-quick-view-btn" data-bs-toggle="modal" data-bs-target="#producQuickViewModal">
                                                            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99948 5.06828C7.80247 5.06828 6.82956 6.04044 6.82956 7.23542C6.82956 8.42951 7.80247 9.40077 8.99948 9.40077C10.1965 9.40077 11.1703 8.42951 11.1703 7.23542C11.1703 6.04044 10.1965 5.06828 8.99948 5.06828ZM8.99942 10.7482C7.0581 10.7482 5.47949 9.17221 5.47949 7.23508C5.47949 5.29705 7.0581 3.72021 8.99942 3.72021C10.9407 3.72021 12.5202 5.29705 12.5202 7.23508C12.5202 9.17221 10.9407 10.7482 8.99942 10.7482Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.41273 7.2346C3.08674 10.9265 5.90646 13.1215 8.99978 13.1224C12.0931 13.1215 14.9128 10.9265 16.5868 7.2346C14.9128 3.54363 12.0931 1.34863 8.99978 1.34773C5.90736 1.34863 3.08674 3.54363 1.41273 7.2346ZM9.00164 14.4703H8.99804H8.99714C5.27471 14.4676 1.93209 11.8629 0.0546754 7.50073C-0.0182251 7.33091 -0.0182251 7.13864 0.0546754 6.96883C1.93209 2.60759 5.27561 0.00288103 8.99714 0.000185582C8.99894 -0.000712902 8.99894 -0.000712902 8.99984 0.000185582C9.00164 -0.000712902 9.00164 -0.000712902 9.00254 0.000185582C12.725 0.00288103 16.0676 2.60759 17.945 6.96883C18.0188 7.13864 18.0188 7.33091 17.945 7.50073C16.0685 11.8629 12.725 14.4676 9.00254 14.4703H9.00164Z" fill="currentColor"/>
                                                            </svg>
                                                            <span class="tp-product-tooltip tp-product-tooltip-right">مشاهده سریع</span>
                                                        </button>

                                                        <a href="{{ route('add.to.favorites', ['product' => $product]) }}" class="tp-product-action-btn-2 tp-product-add-to-wishlist-btn">
                                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.60355 7.98635C2.83622 11.8048 7.7062 14.8923 9.0004 15.6565C10.299 14.8844 15.2042 11.7628 16.3973 7.98985C17.1806 5.55102 16.4535 2.46177 13.5644 1.53473C12.1647 1.08741 10.532 1.35966 9.40484 2.22804C9.16921 2.40837 8.84214 2.41187 8.60476 2.23329C7.41078 1.33952 5.85105 1.07778 4.42936 1.53473C1.54465 2.4609 0.820172 5.55014 1.60355 7.98635ZM9.00138 17.0711C8.89236 17.0711 8.78421 17.0448 8.68574 16.9914C8.41055 16.8417 1.92808 13.2841 0.348132 8.3872C0.347252 8.3872 0.347252 8.38633 0.347252 8.38633C-0.644504 5.30321 0.459792 1.42874 4.02502 0.284605C5.69904 -0.254635 7.52342 -0.0174044 8.99874 0.909632C10.4283 0.00973263 12.3275 -0.238878 13.9681 0.284605C17.5368 1.43049 18.6446 5.30408 17.6538 8.38633C16.1248 13.2272 9.59485 16.8382 9.3179 16.9896C9.21943 17.0439 9.1104 17.0711 9.00138 17.0711Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.203 6.67473C13.8627 6.67473 13.5743 6.41474 13.5462r 6.07159C13.4882 5.35202 13.0046 4.7445 12.3162 4.52302C11.9689 4.41097 11.779 4.04068 11.8906 3.69666C12.0041 3.35175 12.3724 3.16442 12.7206 3.27297C13.919 3.65901 14.7586 4.71561 14.8615 5.96479C14.8905 6.32632 14.6206 6.64322 14.2575 6.6721C14.239 6.67385 14.2214 6.67473 14.203 6.67473Z" fill="currentColor"/>
                                                            </svg>
                                                            <span class="tp-product-tooltip tp-product-tooltip-right">افزودن به لیست علاقه مندی ها</span>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tp-product-content-2 pt-15">
                                                <div class="tp-product-tag-2">
                                                    <a href="#">{{ $product->tags_string }}</a>
                                                </div>

                                                <h3 class="tp-product-title-2">
                                                    <a href="product-details.html">{{ $product->name }} </a>
                                                </h3>

                                                <div class="tp-product-rating-icon tp-product-rating-icon-2">
                                                    @for ($i = 1; $i <= 5; $i++)

                                                        @if($product->get_rating >= $i)
                                                            <span class="stars-active">
                                                                <i aria-hidden="true" class="fa fa-star"></i>
                                                            </span>
                                                        @else
                                                            <span class="stars-inactive">
                                                                <i aria-hidden="true" class="fa fa-star" style="color: #807474;"></i>
                                                            </span>
                                                        @endif

                                                    @endfor
                                                </div>

                                                <div class="tp-product-price-wrapper-2">
                                                    @if($product->discount)
                                                        <span class="tp-product-price-2 new-price">{{ $product->new_price }}</span>
                                                        <span class="tp-product-price-2 old-price">{{ $product->old_price }}</span>
                                                    @elseif(!$product->inventory)
                                                        <span class="text-danger">ناموجود</span>
                                                    @else
                                                        <span class="tp-product-price-2 new-price">{{ $product->old_price }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div> هیچ آیتمی ثبت نشده است</div>
                                @endforelse
                            </div>
                        </div>

                        @foreach($categories as $category)
                            <div class="tab-pane fade" id="nav-{{ $category->id }}" role="tabpanel" aria-labelledby="nav-{{ $category->id }}-tab" tabindex="0">
                                <div class="row">
                                @forelse($category->products as $product)

                                        <div class="col-xl-3 col-md-6 col-sm-6 infinite-item">
                                        <div class="tp-product-item-2 mb-40">
                                            <div class="tp-product-thumb-2 p-relative z-index-1 fix w-img">
                                                <a href="product-details.html">
                                                    {{--  <img src="{{ $product->images()->first()->path }}" alt="">  --}}
                                                    <img src="{{('site/assets/img/product/2/prodcut-1.jpg') }}"alt="">
                                                </a>
                                                <!-- product action -->
                                                <div class="tp-product-action-2 tp-product-action-blackStyle">
                                                    <div class="tp-product-action-item-2 d-flex flex-column">

                                                        <a href="{{ route('add.to.cart', ['product' => $product]) }}" class="tp-product-action-btn-2 tp-product-add-cart-btn">
                                                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.34706 4.53799L3.85961 10.6239C3.89701 11.0923 4.28036 11.4436 4.74871 11.4436H4.75212H14.0265H14.0282C14.4711 11.4436 14.8493 11.1144 14.9122 10.6774L15.7197 5.11162C15.7384 4.97924 15.7053 4.84687 15.6245 4.73995C15.5446 4.63218 15.4273 4.5626 15.2947 4.54393C15.1171 4.55072 7.74498 4.54054 3.34706 4.53799ZM4.74722 12.7162C3.62777 12.7162 2.68001 11.8438 2.58906 10.728L1.81046 1.4837L0.529505 1.26308C0.181854 1.20198 -0.0501969 0.873587 0.00930333 0.526523C0.0705036 0.17946 0.406255 -0.0462578 0.746256 0.00805037L2.51426 0.313534C2.79901 0.363599 3.01576 0.5995 3.04042 0.888012L3.24017 3.26484C15.3748 3.26993 15.4139 3.27587 15.4726 3.28266C15.946 3.3514 16.3625 3.59833 16.6464 3.97849C16.9303 4.35779 17.0493 4.82535 16.9813 5.29376L16.1747 10.8586C16.0225 11.9177 15.1011 12.7162 14.0301 12.7162H14.0259H4.75402H4.74722Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6629 7.67446H10.3067C9.95394 7.67446 9.66919 7.38934 9.66919 7.03804C9.66919 6.68673 9.95394 6.40161 10.3067 6.40161H12.6629C13.0148 6.40161 13.3004 6.68673 13.3004 7.03804C13.3004 7.38934 13.0148 7.67446 12.6629 7.67446Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.38171 15.0212C4.63756 15.0212 4.84411 15.2278 4.84411 15.4836C4.84411 15.7395 4.63756 15.9469 4.38171 15.9469C4.12501 15.9469 3.91846 15.7395 3.91846 15.4836C3.91846 15.2278 4.12501 15.0212 4.38171 15.0212Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.38082 15.3091C4.28477 15.3091 4.20657 15.3873 4.20657 15.4833C4.20657 15.6763 4.55592 15.6763 4.55592 15.4833C4.55592 15.3873 4.47687 15.3091 4.38082 15.3091ZM4.38067 16.5815C3.77376 16.5815 3.28076 16.0884 3.28076 15.4826C3.28076 14.8767 3.77376 14.3845 4.38067 14.3845C4.98757 14.3845 5.48142 14.8767 5.48142 15.4826C5.48142 16.0884 4.98757 16.5815 4.38067 16.5815Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9701 15.0212C14.2259 15.0212 14.4333 15.2278 14.4333 15.4836C14.4333 15.7395 14.2259 15.9469 13.9701 15.9469C13.7134 15.9469 13.5068 15.7395 13.5068 15.4836C13.5068 15.2278 13.7134 15.0212 13.9701 15.0212Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9692 15.3092C13.874 15.3092 13.7958 15.3874 13.7958 15.4835C13.7966 15.6781 14.1451 15.6764 14.1443 15.4835C14.1443 15.3874 14.0652 15.3092 13.9692 15.3092ZM13.969 16.5815C13.3621 16.5815 12.8691 16.0884 12.8691 15.4826C12.8691 14.8767 13.3621 14.3845 13.969 14.3845C14.5768 14.3845 15.0706 14.8767 15.0706 15.4826C15.0706 16.0884 14.5768 16.5815 13.969 16.5815Z" fill="currentColor"/>
                                                            </svg>
                                                            <span class="tp-product-tooltip tp-product-tooltip-right">به سبد خرید اضافه کنید</span>
                                                        </a>

                                                        <button type="button" class="tp-product-action-btn-2 tp-product-quick-view-btn" data-bs-toggle="modal" data-bs-target="#producQuickViewModal">
                                                            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99948 5.06828C7.80247 5.06828 6.82956 6.04044 6.82956 7.23542C6.82956 8.42951 7.80247 9.40077 8.99948 9.40077C10.1965 9.40077 11.1703 8.42951 11.1703 7.23542C11.1703 6.04044 10.1965 5.06828 8.99948 5.06828ZM8.99942 10.7482C7.0581 10.7482 5.47949 9.17221 5.47949 7.23508C5.47949 5.29705 7.0581 3.72021 8.99942 3.72021C10.9407 3.72021 12.5202 5.29705 12.5202 7.23508C12.5202 9.17221 10.9407 10.7482 8.99942 10.7482Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.41273 7.2346C3.08674 10.9265 5.90646 13.1215 8.99978 13.1224C12.0931 13.1215 14.9128 10.9265 16.5868 7.2346C14.9128 3.54363 12.0931 1.34863 8.99978 1.34773C5.90736 1.34863 3.08674 3.54363 1.41273 7.2346ZM9.00164 14.4703H8.99804H8.99714C5.27471 14.4676 1.93209 11.8629 0.0546754 7.50073C-0.0182251 7.33091 -0.0182251 7.13864 0.0546754 6.96883C1.93209 2.60759 5.27561 0.00288103 8.99714 0.000185582C8.99894 -0.000712902 8.99894 -0.000712902 8.99984 0.000185582C9.00164 -0.000712902 9.00164 -0.000712902 9.00254 0.000185582C12.725 0.00288103 16.0676 2.60759 17.945 6.96883C18.0188 7.13864 18.0188 7.33091 17.945 7.50073C16.0685 11.8629 12.725 14.4676 9.00254 14.4703H9.00164Z" fill="currentColor"/>
                                                            </svg>
                                                            <span class="tp-product-tooltip tp-product-tooltip-right">مشاهده سریع</span>
                                                        </button>

                                                        <a href="{{ route('add.to.favorites', ['product' => $product]) }}" class="tp-product-action-btn-2 tp-product-add-to-wishlist-btn">
                                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.60355 7.98635C2.83622 11.8048 7.7062 14.8923 9.0004 15.6565C10.299 14.8844 15.2042 11.7628 16.3973 7.98985C17.1806 5.55102 16.4535 2.46177 13.5644 1.53473C12.1647 1.08741 10.532 1.35966 9.40484 2.22804C9.16921 2.40837 8.84214 2.41187 8.60476 2.23329C7.41078 1.33952 5.85105 1.07778 4.42936 1.53473C1.54465 2.4609 0.820172 5.55014 1.60355 7.98635ZM9.00138 17.0711C8.89236 17.0711 8.78421 17.0448 8.68574 16.9914C8.41055 16.8417 1.92808 13.2841 0.348132 8.3872C0.347252 8.3872 0.347252 8.38633 0.347252 8.38633C-0.644504 5.30321 0.459792 1.42874 4.02502 0.284605C5.69904 -0.254635 7.52342 -0.0174044 8.99874 0.909632C10.4283 0.00973263 12.3275 -0.238878 13.9681 0.284605C17.5368 1.43049 18.6446 5.30408 17.6538 8.38633C16.1248 13.2272 9.59485 16.8382 9.3179 16.9896C9.21943 17.0439 9.1104 17.0711 9.00138 17.0711Z" fill="currentColor"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.203 6.67473C13.8627 6.67473 13.5743 6.41474 13.5462r 6.07159C13.4882 5.35202 13.0046 4.7445 12.3162 4.52302C11.9689 4.41097 11.779 4.04068 11.8906 3.69666C12.0041 3.35175 12.3724 3.16442 12.7206 3.27297C13.919 3.65901 14.7586 4.71561 14.8615 5.96479C14.8905 6.32632 14.6206 6.64322 14.2575 6.6721C14.239 6.67385 14.2214 6.67473 14.203 6.67473Z" fill="currentColor"/>
                                                            </svg>
                                                            <span class="tp-product-tooltip tp-product-tooltip-right">افزودن به لیست علاقه مندی ها</span>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tp-product-content-2 pt-15">
                                                <div class="tp-product-tag-2">
                                                    <a href="#">{{ $product->tags_string }}</a>
                                                </div>

                                                <h3 class="tp-product-title-2">
                                                    <a href="product-details.html">{{ $product->name }} </a>
                                                </h3>

                                                <div class="tp-product-rating-icon tp-product-rating-icon-2">
                                                    @for ($i = 1; $i <= 5; $i++)

                                                        @if($product->get_rating >= $i)
                                                            <span class="stars-active">
                                                                <i aria-hidden="true" class="fa fa-star"></i>
                                                            </span>
                                                        @else
                                                            <span class="stars-inactive">
                                                                <i aria-hidden="true" class="fa fa-star" style="color: #807474;"></i>
                                                            </span>
                                                        @endif

                                                    @endfor
                                                </div>

                                                <div class="tp-product-price-wrapper-2">
                                                    @if($product->discount)
                                                        <span class="tp-product-price-2 new-price">{{ $product->new_price }}</span>
                                                        <span class="tp-product-price-2 old-price">{{ $product->old_price }}</span>
                                                    @elseif(!$product->inventory)
                                                        <span class="text-danger">ناموجود</span>
                                                    @else
                                                        <span class="tp-product-price-2 new-price">{{ $product->old_price }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    @empty
                                        <div> هیچ آیتمی ثبت نشده است</div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="tp-featured-slider-area grey-bg-6 fix pt-95 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="tp-section-title-wrapper-2 mb-50">
                <span class="tp-section-title-pre-2">
                    منتخب محصولات تخفیف و حراج
                    <svg width="82" height="22" viewBox="0 0 82 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M81 14.5798C0.890564 -8.05914 -5.81154 0.0503902 5.00322 21" stroke="currentColor" stroke-opacity="0.3" stroke-width="2" stroke-miterlimit="3.8637" stroke-linecap="round"/>
                    </svg>
                </span>
                <h3 class="tp-section-title-2">ویژه های این هفته</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="tp-featured-slider">
                <div class="tp-featured-slider-active swiper-container">
                    <div class="swiper-wrapper">
                        <div class="tp-featured-item swiper-slide white-bg p-relative z-index-1">
                            <div class="tp-featured-thumb include-bg" data-background="{{ asset('site/assets/img/product/slider/product-slider-1.jpg') }}></div>
                            <div class="tp-featured-content">
                            <h3 class="tp-featured-title">
                                <a href="product-details.html">لباس <br> مجموعه 2023</a>
                            </h3>
                            <div class="tp-featured-price-wrapper">
                                <span class="tp-featured-price new-price">102.00 تومان</span>
                                <span class="tp-featured-price old-price">226.00 تومان</span>
                            </div>
                            <div class="tp-product-rating-icon tp-product-rating-icon-2">
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                            </div>
                            <div class="tp-featured-btn">
                                <a href="product-details.html" class="tp-btn tp-btn-border tp-btn-border-sm">خرید
                                    <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 7.49988L1 7.49988" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.9502 1.47554L16.0002 7.49954L9.9502 13.5245" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                            </div>
                        </div>
                        <div class="tp-featured-item swiper-slide white-bg p-relative z-index-1">
                            <div class="tp-featured-thumb include-bg" data-background="{{ asset('site/assets/img/product/slider/product-slider-2.jpg') }}></div>
                            <div class="tp-featured-content">
                            <h3 class="tp-featured-title">
                                <a href="product-details.html">ورزشی بدون لغزش <br> پیاده روی تنیس</a>
                            </h3>
                            <div class="tp-featured-price-wrapper">
                                <span class="tp-featured-price new-price">220.00 تومان</span>
                                <span class="tp-featured-price old-price">350.00 تومان</span>
                            </div>
                            <div class="tp-product-rating-icon tp-product-rating-icon-2">
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                            </div>
                            <div class="tp-featured-btn">
                                <a href="product-details.html" class="tp-btn tp-btn-border tp-btn-border-sm">خرید
                                    <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 7.49988L1 7.49988" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.9502 1.47554L16.0002 7.49954L9.9502 13.5245" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                            </div>
                        </div>
                        <div class="tp-featured-item swiper-slide white-bg p-relative z-index-1">
                            <div class="tp-featured-thumb include-bg" data-background="{{ asset('site/assets/img/product/slider/product-slider-3.jpg') }}></div>
                            <div class="tp-featured-content">
                            <h3 class="tp-featured-title">
                                <a href="product-details.html">ورزشی بدون لغزش <br> پیاده روی تنیس</a>
                            </h3>
                            <div class="tp-featured-price-wrapper">
                                <span class="tp-featured-price new-price">220.00 تومان</span>
                                <span class="tp-featured-price old-price">350.00 تومان</span>
                            </div>
                            <div class="tp-product-rating-icon tp-product-rating-icon-2">
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                            </div>
                            <div class="tp-featured-btn">
                                <a href="product-details.html" class="tp-btn tp-btn-border tp-btn-border-sm">خرید
                                    <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 7.49988L1 7.49988" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.9502 1.47554L16.0002 7.49954L9.9502 13.5245" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                            </div>
                        </div>
                        <div class="tp-featured-item swiper-slide white-bg p-relative z-index-1">
                            <div class="tp-featured-thumb include-bg" data-background="{{ asset('site/assets/img/product/slider/product-slider-4.jpg') }}></div>
                            <div class="tp-featured-content">
                            <h3 class="tp-featured-title">
                                <a href="product-details.html">ورزشی بدون لغزش <br> پیاده روی تنیس</a>
                            </h3>
                            <div class="tp-featured-price-wrapper">
                                <span class="tp-featured-price new-price">220.00 تومان</span>
                                <span class="tp-featured-price old-price">350.00 تومان</span>
                            </div>
                            <div class="tp-product-rating-icon tp-product-rating-icon-2">
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                            </div>
                            <div class="tp-featured-btn">
                                <a href="product-details.html" class="tp-btn tp-btn-border tp-btn-border-sm">خرید
                                    <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 7.49988L1 7.49988" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.9502 1.47554L16.0002 7.49954L9.9502 13.5245" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                            </div>
                        </div>
                        <div class="tp-featured-item swiper-slide white-bg p-relative z-index-1">
                            <div class="tp-featured-thumb include-bg" data-background="{{ asset('site/assets/img/product/slider/product-slider-5.jpg') }}></div>
                            <div class="tp-featured-content">
                            <h3 class="tp-featured-title">
                                <a href="product-details.html">ورزشی بدون لغزش <br> پیاده روی تنیس</a>
                            </h3>
                            <div class="tp-featured-price-wrapper">
                                <span class="tp-featured-price new-price">220.00 تومان</span>
                                <span class="tp-featured-price old-price">350.00 تومان</span>
                            </div>
                            <div class="tp-product-rating-icon tp-product-rating-icon-2">
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                            </div>
                            <div class="tp-featured-btn">
                                <a href="product-details.html" class="tp-btn tp-btn-border tp-btn-border-sm">خرید
                                    <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 7.49988L1 7.49988" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9.9502 1.47554L16.0002 7.49954L9.9502 13.5245" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tp-featured-slider-arrow mt-45">
                    <button class="tp-featured-slider-button-prev">
                        <svg width="33" height="16" viewBox="0 0 33 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.97974 7.97534L31.9797 7.97534" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8.02954 0.999999L0.999912 7.99942L8.02954 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="tp-featured-slider-button-next">
                        <svg width="33" height="16" viewBox="0 0 33 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M30.9795 7.97534L0.979492 7.97534" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M24.9297 0.999999L31.9593 7.99942L24.9297 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>
    </section>

    <section class="tp-seller-area pb-140">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="tp-section-title-wrapper-2 mb-50">
                    <span class="tp-section-title-pre-2">
                        پرفروش ترین این هفته
                        <svg width="82" height="22" viewBox="0 0 82 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M81 14.5798C0.890564 -8.05914 -5.81154 0.0503902 5.00322 21" stroke="currentColor" stroke-opacity="0.3" stroke-width="2.00322" stroke-opacity="0.3" stroke-width="2. "/>
                        </svg>
                        </span>
                        <h3 class="tp-section-title-2">ویژه های این هفته</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse($bestSellersOfTheWeek as $best_seller)
                        <div class="col-xl-3 col-md-6 col-sm-6 infinite-item">
                        <div class="tp-product-item-2 mb-40">
                            <div class="tp-product-thumb-2 p-relative z-index-1 fix w-img">
                                <a href="product-details.html">
                                    {{--  <img src="{{ $product->images()->first()->path }}" alt="">  --}}
                                    <img src="{{('site/assets/img/product/2/prodcut-1.jpg') }}"alt="">
                                </a>
                                <!-- product action -->
                                <div class="tp-product-action-2 tp-product-action-blackStyle">
                                    <div class="tp-product-action-item-2 d-flex flex-column">

                                        <a href="{{ route('add.to.cart', ['product' => $best_seller]) }}" class="tp-product-action-btn-2 tp-product-add-cart-btn">
                                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.34706 4.53799L3.85961 10.6239C3.89701 11.0923 4.28036 11.4436 4.74871 11.4436H4.75212H14.0265H14.0282C14.4711 11.4436 14.8493 11.1144 14.9122 10.6774L15.7197 5.11162C15.7384 4.97924 15.7053 4.84687 15.6245 4.73995C15.5446 4.63218 15.4273 4.5626 15.2947 4.54393C15.1171 4.55072 7.74498 4.54054 3.34706 4.53799ZM4.74722 12.7162C3.62777 12.7162 2.68001 11.8438 2.58906 10.728L1.81046 1.4837L0.529505 1.26308C0.181854 1.20198 -0.0501969 0.873587 0.00930333 0.526523C0.0705036 0.17946 0.406255 -0.0462578 0.746256 0.00805037L2.51426 0.313534C2.79901 0.363599 3.01576 0.5995 3.04042 0.888012L3.24017 3.26484C15.3748 3.26993 15.4139 3.27587 15.4726 3.28266C15.946 3.3514 16.3625 3.59833 16.6464 3.97849C16.9303 4.35779 17.0493 4.82535 16.9813 5.29376L16.1747 10.8586C16.0225 11.9177 15.1011 12.7162 14.0301 12.7162H14.0259H4.75402H4.74722Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.6629 7.67446H10.3067C9.95394 7.67446 9.66919 7.38934 9.66919 7.03804C9.66919 6.68673 9.95394 6.40161 10.3067 6.40161H12.6629C13.0148 6.40161 13.3004 6.68673 13.3004 7.03804C13.3004 7.38934 13.0148 7.67446 12.6629 7.67446Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.38171 15.0212C4.63756 15.0212 4.84411 15.2278 4.84411 15.4836C4.84411 15.7395 4.63756 15.9469 4.38171 15.9469C4.12501 15.9469 3.91846 15.7395 3.91846 15.4836C3.91846 15.2278 4.12501 15.0212 4.38171 15.0212Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.38082 15.3091C4.28477 15.3091 4.20657 15.3873 4.20657 15.4833C4.20657 15.6763 4.55592 15.6763 4.55592 15.4833C4.55592 15.3873 4.47687 15.3091 4.38082 15.3091ZM4.38067 16.5815C3.77376 16.5815 3.28076 16.0884 3.28076 15.4826C3.28076 14.8767 3.77376 14.3845 4.38067 14.3845C4.98757 14.3845 5.48142 14.8767 5.48142 15.4826C5.48142 16.0884 4.98757 16.5815 4.38067 16.5815Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9701 15.0212C14.2259 15.0212 14.4333 15.2278 14.4333 15.4836C14.4333 15.7395 14.2259 15.9469 13.9701 15.9469C13.7134 15.9469 13.5068 15.7395 13.5068 15.4836C13.5068 15.2278 13.7134 15.0212 13.9701 15.0212Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9692 15.3092C13.874 15.3092 13.7958 15.3874 13.7958 15.4835C13.7966 15.6781 14.1451 15.6764 14.1443 15.4835C14.1443 15.3874 14.0652 15.3092 13.9692 15.3092ZM13.969 16.5815C13.3621 16.5815 12.8691 16.0884 12.8691 15.4826C12.8691 14.8767 13.3621 14.3845 13.969 14.3845C14.5768 14.3845 15.0706 14.8767 15.0706 15.4826C15.0706 16.0884 14.5768 16.5815 13.969 16.5815Z" fill="currentColor"/>
                                            </svg>
                                            <span class="tp-product-tooltip tp-product-tooltip-right">به سبد خرید اضافه کنید</span>
                                        </a>

                                        <button type="button" class="tp-product-action-btn-2 tp-product-quick-view-btn" data-bs-toggle="modal" data-bs-target="#producQuickViewModal">
                                            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99948 5.06828C7.80247 5.06828 6.82956 6.04044 6.82956 7.23542C6.82956 8.42951 7.80247 9.40077 8.99948 9.40077C10.1965 9.40077 11.1703 8.42951 11.1703 7.23542C11.1703 6.04044 10.1965 5.06828 8.99948 5.06828ZM8.99942 10.7482C7.0581 10.7482 5.47949 9.17221 5.47949 7.23508C5.47949 5.29705 7.0581 3.72021 8.99942 3.72021C10.9407 3.72021 12.5202 5.29705 12.5202 7.23508C12.5202 9.17221 10.9407 10.7482 8.99942 10.7482Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.41273 7.2346C3.08674 10.9265 5.90646 13.1215 8.99978 13.1224C12.0931 13.1215 14.9128 10.9265 16.5868 7.2346C14.9128 3.54363 12.0931 1.34863 8.99978 1.34773C5.90736 1.34863 3.08674 3.54363 1.41273 7.2346ZM9.00164 14.4703H8.99804H8.99714C5.27471 14.4676 1.93209 11.8629 0.0546754 7.50073C-0.0182251 7.33091 -0.0182251 7.13864 0.0546754 6.96883C1.93209 2.60759 5.27561 0.00288103 8.99714 0.000185582C8.99894 -0.000712902 8.99894 -0.000712902 8.99984 0.000185582C9.00164 -0.000712902 9.00164 -0.000712902 9.00254 0.000185582C12.725 0.00288103 16.0676 2.60759 17.945 6.96883C18.0188 7.13864 18.0188 7.33091 17.945 7.50073C16.0685 11.8629 12.725 14.4676 9.00254 14.4703H9.00164Z" fill="currentColor"/>
                                            </svg>
                                            <span class="tp-product-tooltip tp-product-tooltip-right">مشاهده سریع</span>
                                        </button>

                                        <a href="{{ route('add.to.favorites', ['product' => $best_seller]) }}" class="tp-product-action-btn-2 tp-product-add-to-wishlist-btn">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.60355 7.98635C2.83622 11.8048 7.7062 14.8923 9.0004 15.6565C10.299 14.8844 15.2042 11.7628 16.3973 7.98985C17.1806 5.55102 16.4535 2.46177 13.5644 1.53473C12.1647 1.08741 10.532 1.35966 9.40484 2.22804C9.16921 2.40837 8.84214 2.41187 8.60476 2.23329C7.41078 1.33952 5.85105 1.07778 4.42936 1.53473C1.54465 2.4609 0.820172 5.55014 1.60355 7.98635ZM9.00138 17.0711C8.89236 17.0711 8.78421 17.0448 8.68574 16.9914C8.41055 16.8417 1.92808 13.2841 0.348132 8.3872C0.347252 8.3872 0.347252 8.38633 0.347252 8.38633C-0.644504 5.30321 0.459792 1.42874 4.02502 0.284605C5.69904 -0.254635 7.52342 -0.0174044 8.99874 0.909632C10.4283 0.00973263 12.3275 -0.238878 13.9681 0.284605C17.5368 1.43049 18.6446 5.30408 17.6538 8.38633C16.1248 13.2272 9.59485 16.8382 9.3179 16.9896C9.21943 17.0439 9.1104 17.0711 9.00138 17.0711Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.203 6.67473C13.8627 6.67473 13.5743 6.41474 13.5462r 6.07159C13.4882 5.35202 13.0046 4.7445 12.3162 4.52302C11.9689 4.41097 11.779 4.04068 11.8906 3.69666C12.0041 3.35175 12.3724 3.16442 12.7206 3.27297C13.919 3.65901 14.7586 4.71561 14.8615 5.96479C14.8905 6.32632 14.6206 6.64322 14.2575 6.6721C14.239 6.67385 14.2214 6.67473 14.203 6.67473Z" fill="currentColor"/>
                                            </svg>
                                            <span class="tp-product-tooltip tp-product-tooltip-right">افزودن به لیست علاقه مندی ها</span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <div class="tp-product-content-2 pt-15">
                                <div class="tp-product-tag-2">
                                    <a href="#">{{ $best_seller->tags_string }}</a>
                                </div>

                                <h3 class="tp-product-title-2">
                                    <a href="product-details.html">{{ $best_seller->name }} </a>
                                </h3>

                                <div class="tp-product-rating-icon tp-product-rating-icon-2">
                                    @for ($i = 1; $i <= 5; $i++)

                                        @if($best_seller->get_rating >= $i)
                                            <span class="stars-active">
                                                <i aria-hidden="true" class="fa fa-star"></i>
                                            </span>
                                        @else
                                            <span class="stars-inactive">
                                                <i aria-hidden="true" class="fa fa-star" style="color: #807474;"></i>
                                            </span>
                                        @endif

                                    @endfor
                                </div>

                                <div class="tp-product-price-wrapper-2">
                                    @if($best_seller->discount)
                                        <span class="tp-product-price-2 new-price">{{ $best_seller->new_price }}</span>
                                        <span class="tp-product-price-2 old-price">{{ $best_seller->old_price }}</span>
                                    @else
                                        <span class="tp-product-price-2 new-price">{{ $best_seller->old_price }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        </div>
                    @empty
                        <div> هیچ آیتمی ثبت نشده است</div>
                    @endforelse
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="tp-seller-more text-center mt-10">
                        <a href="shop.html" class="tp-btn tp-btn-border tp-btn-border-sm">مشاهده همه محصولات</a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="modal fade tp-product-modal tp-product-modal-styleDarkRed" id="producQuickViewModal" tabindex="-1" aria-labelledby="producQuickViewModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="tp-product-modal-content d-lg-flex align-items-start">

                    <button type="button" class="tp-product-modal-close-btn" data-bs-toggle="modal" data-bs-target="#producQuickViewModal">
                        <i class="fa-regular fa-xmark"></i>
                    </button>

                    <div class="tp-product-details-thumb-wrapper tp-tab d-sm-flex">

                        <nav>
                            <div class="nav nav-tabs flex-sm-column " id="productDetailsNavThumb" role="tablist">
                                <button class="nav-link active" id="nav-1-tab" data-bs-toggle="tab" data-bs-target="#nav-1" type="button" role="tab" aria-controls="nav-1" aria-selected="true">
                                    <img src="{{ ('site/assets/img/product/details/3/nav/product-details-nav-1.jpg') }}"alt="">
                                </button>
                                <button class="nav-link" id="nav-2-tab" data-bs-toggle="tab" data-bs-target="#nav-2" type="button" role="tab" aria-controls="nav-2" aria-selected="false">
                                    <img src="{{ ('site/assets/img/product/details/3/nav/product-details-nav-2.jpg') }}"alt="">
                                </button>
                                <button class="nav-link" id="nav-3-tab" data-bs-toggle="tab" data-bs-target="#nav-3" type="button" role="tab" aria-controls="nav-3" aria-selected="false">
                                    <img src="{{('site/assets/img/product/details/3/nav/product-details-nav-3.jpg') }}"alt="">
                                </button>
                                <button class="nav-link" id="nav-4-tab" data-bs-toggle="tab" data-bs-target="#nav-4" type="button" role="tab" aria-controls="nav-4" aria-selected="false">
                                    <img src="{{('site/assets/img/product/details/3/nav/product-details-nav-4.jpg') }}"alt="">
                                </button>
                            </div>
                        </nav>

                        <div class="tab-content m-img" id="productDetailsNavContent">

                            <div class="tab-pane fade show active" id="nav-1" role="tabpanel" aria-labelledby="nav-1-tab" tabindex="0">
                                <div class="tp-product-details-nav-main-thumb">
                                    <img src="{{('site/assets/img/product/details/3/main/product-details-main-1.jpg') }}"alt="">
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-2" role="tabpanel" aria-labelledby="nav-2-tab" tabindex="0">
                                <div class="tp-product-details-nav-main-thumb">
                                    <img src="{{('site/assets/img/product/details/3/main/product-details-main-2.jpg') }}"alt="">
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-3" role="tabpanel" aria-labelledby="nav-3-tab" tabindex="0">
                                <div class="tp-product-details-nav-main-thumb">
                                    <img src="{{('site/assets/img/product/details/3/main/product-details-main-3.jpg') }}"alt="">
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-4" role="tabpanel" aria-labelledby="nav-4-tab" tabindex="0">
                                <div class="tp-product-details-nav-main-thumb">
                                    <img src="{{('site/assets/img/product/details/3/main/product-details-main-4.jpg') }}"alt="">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="tp-product-details-wrapper">

                        <div class="tp-product-details-category">
                            <span>{{ $product->category->name }}</span>
                        </div>

                        <h3 class="to-product-details-title">{{ $product->name }}</h3>

                        <div class="tp-product-details-inventory d-flex align-items-center mb-10">
                            <div class="tp-product-details-stock mb-10">
                                <span>In Stock</span>
                            </div>

                            <div class="tp-product-details-rating-wrapper d-flex align-items-center mb-10">

                                <div class="tp-product-details-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($product->get_rating >= $i)
                                            <span class="stars-active">
                                                <i aria-hidden="true" class="fa fa-star"></i>
                                            </span>
                                        @else
                                            <span class="stars-inactive">
                                                <i aria-hidden="true" class="fa fa-star" style="color: #807474;"></i>
                                            </span>
                                        @endif
                                    @endfor
                                </div>


                                <div class="tp-product-details-reviews">
                                    <span>({{ $product->get_vote }} دیدگاه)</span>
                                </div>

                            </div>
                        </div>
                        <p>{{ $product->description }}</p>

                        <div class="tp-product-details-price-wrapper mb-20">
                            @if($product->discount)
                                <span class="tp-product-price-2 new-price">{{ $product->new_price }}</span>
                                <span class="tp-product-price-2 old-price">{{ $product->old_price }}</span>
                            @elseif(!$product->inventory)
                                <span class="text-danger">ناموجود</span>
                            @else
                                <span class="tp-product-price-2 new-price">{{ $product->old_price }}</span>
                            @endif
                        </div>

                        <div class="tp-product-details-variation">
                            <div class="tp-product-details-variation-item">
                                <h4 class="tp-product-details-variation-title">رنگ :</h4>
                                <div class="tp-product-details-variation-list">
                                    @foreach($product->colors as $color)
                                        <button type="button" class="color tp-color-variation-btn" >
                                            <span data-bg-color="{{ $color->code }}"></span>
                                            <span class="tp-color-variation-tootltip">{{ $color->name }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tp-product-details-variation-item">
                                <h4 class="tp-product-details-variation-title">سایز :</h4>
                                <div class="tp-product-details-variation-list">
                                    @foreach($product->sizes as $size)
                                        <button type="button" class="">
                                            <span class="">{{ $size->name }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="tp-product-details-action-wrapper">
                            <h3 class="tp-product-details-action-title">کیفیت</h3>
                            <div class="tp-product-details-action-item-wrapper d-sm-flex align-items-center">
                                <div class="tp-product-details-quantity">
                                    <div class="tp-product-quantity mb-15 mr-15">
                                    <span class="tp-cart-minus">
                                        <svg width="11" height="2" viewBox="0 0 11 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                    <input class="tp-cart-input" type="text" value="1">
                                    <span class="tp-cart-plus">
                                        <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 6H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M5.5 10.5V1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                    </div>
                                </div>

                                <div class="tp-product-details-add-to-cart mb-15 w-100">
                                    <button class="tp-product-details-add-to-cart-btn w-100">افزودن به سبد خرید</button>
                                </div>

                            </div>

                            <button class="tp-product-details-buy-now-btn w-100">خرید</button>

                        </div>

                        <div class="tp-product-details-action-sm">

                            <a href="{{ route('add.to.favorites', ['product' => $product]) }}" class="tp-product-details-action-sm-btn">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.33541 7.54172C3.36263 10.6766 7.42094 13.2113 8.49945 13.8387C9.58162 13.2048 13.6692 10.6421 14.6635 7.5446C15.3163 5.54239 14.7104 3.00621 12.3028 2.24514C11.1364 1.8779 9.77578 2.1014 8.83648 2.81432C8.64012 2.96237 8.36757 2.96524 8.16974 2.81863C7.17476 2.08487 5.87499 1.86999 4.69024 2.24514C2.28632 3.00549 1.68259 5.54167 2.33541 7.54172ZM8.50115 15C8.4103 15 8.32018 14.9784 8.23812 14.9346C8.00879 14.8117 2.60674 11.891 1.29011 7.87081C1.28938 7.87081 1.28938 7.8701 1.28938 7.8701C0.462913 5.33895 1.38316 2.15812 4.35418 1.21882C5.7492 0.776121 7.26952 0.97088 8.49895 1.73195C9.69029 0.993159 11.2729 0.789057 12.6401 1.21882C15.614 2.15956 16.5372 5.33966 15.7115 7.8701C14.4373 11.8443 8.99571 14.8088 8.76492 14.9332C8.68286 14.9777 8.592 15 8.50115 15Z" fill="currentColor"/>
                                    <path d="M8.49945 13.8387L8.42402 13.9683L8.49971 14.0124L8.57526 13.9681L8.49945 13.8387ZM14.6635 7.5446L14.5209 7.4981L14.5207 7.49875L14.6635 7.5446ZM12.3028 2.24514L12.348 2.10211L12.3478 2.10206L12.3028 2.24514ZM8.83648 2.81432L8.92678 2.93409L8.92717 2.9338L8.83648 2.81432ZM8.16974 2.81863L8.25906 2.69812L8.25877 2.69791L8.16974 2.81863ZM4.69024 2.24514L4.73548 2.38815L4.73552 2.38814L4.69024 2.24514ZM8.23812 14.9346L8.16727 15.0668L8.16744 15.0669L8.23812 14.9346ZM1.29011 7.87081L1.43266 7.82413L1.39882 7.72081H1.29011V7.87081ZM1.28938 7.8701L1.43938 7.87009L1.43938 7.84623L1.43197 7.82354L1.28938 7.8701ZM4.35418 1.21882L4.3994 1.36184L4.39955 1.36179L4.35418 1.21882ZM8.49895 1.73195L8.42 1.85949L8.49902 1.90841L8.57801 1.85943L8.49895 1.73195ZM12.6401 1.21882L12.6853 1.0758L12.685 1.07572L12.6401 1.21882ZM15.7115 7.8701L15.5689 7.82356L15.5686 7.8243L15.7115 7.8701ZM8.76492 14.9332L8.69378 14.8011L8.69334 14.8013L8.76492 14.9332ZM2.19287 7.58843C2.71935 9.19514 4.01596 10.6345 5.30013 11.744C6.58766 12.8564 7.88057 13.6522 8.42402 13.9683L8.57487 13.709C8.03982 13.3978 6.76432 12.6125 5.49626 11.517C4.22484 10.4185 2.97868 9.02313 2.47795 7.49501L2.19287 7.58843ZM8.57526 13.9681C9.12037 13.6488 10.4214 12.8444 11.7125 11.729C12.9999 10.6167 14.2963 9.17932 14.8063 7.59044L14.5207 7.49875C14.0364 9.00733 12.7919 10.4 11.5164 11.502C10.2446 12.6008 8.9607 13.3947 8.42364 13.7093L8.57526 13.9681ZM14.8061 7.59109C15.1419 6.5613 15.1554 5.39131 14.7711 4.37633C14.3853 3.35729 13.5989 2.49754 12.348 2.10211L12.2576 2.38816C13.4143 2.75381 14.1347 3.54267 14.4905 4.48255C14.8479 5.42648 14.8379 6.52568 14.5209 7.4981L14.8061 7.59109ZM12.3478 2.10206C11.137 1.72085 9.72549 1.95125 8.7458 2.69484L8.92717 2.9338C9.82606 2.25155 11.1357 2.03494 12.2577 2.38821L12.3478 2.10206ZM8.74618 2.69455C8.60221 2.8031 8.40275 2.80462 8.25906 2.69812L8.08043 2.93915C8.33238 3.12587 8.67804 3.12163 8.92678 2.93409L8.74618 2.69455ZM8.25877 2.69791C7.225 1.93554 5.87527 1.71256 4.64496 2.10213L4.73552 2.38814C5.87471 2.02742 7.12452 2.2342 8.08071 2.93936L8.25877 2.69791ZM4.64501 2.10212C3.39586 2.49722 2.61099 3.35688 2.22622 4.37554C1.84299 5.39014 1.85704 6.55957 2.19281 7.58826L2.478 7.49518C2.16095 6.52382 2.15046 5.42513 2.50687 4.48154C2.86175 3.542 3.58071 2.7534 4.73548 2.38815L4.64501 2.10212ZM8.50115 14.85C8.43415 14.85 8.36841 14.8341 8.3088 14.8023L8.16744 15.0669C8.27195 15.1227 8.38645 15.15 8.50115 15.15V14.85ZM8.30897 14.8024C8.19831 14.7431 6.7996 13.9873 5.26616 12.7476C3.72872 11.5046 2.07716 9.79208 1.43266 7.82413L1.14756 7.9175C1.81968 9.96978 3.52747 11.7277 5.07755 12.9809C6.63162 14.2373 8.0486 15.0032 8.16727 15.0668L8.30897 14.8024ZM1.29011 7.72081C1.31557 7.72081 1.34468 7.72745 1.37175 7.74514C1.39802 7.76231 1.41394 7.78437 1.42309 7.8023C1.43191 7.81958 1.43557 7.8351 1.43727 7.84507C1.43817 7.8504 1.43869 7.85518 1.43898 7.85922C1.43913 7.86127 1.43923 7.8632 1.43929 7.865C1.43932 7.86591 1.43934 7.86678 1.43936 7.86763C1.43936 7.86805 1.43937 7.86847 1.43937 7.86888C1.43937 7.86909 1.43937 7.86929 1.43938 7.86949C1.43938 7.86959 1.43938 7.86969 1.43938 7.86979C1.43938 7.86984 1.43938 7.86992 1.43938 7.86994C1.43938 7.87002 1.43938 7.87009 1.28938 7.8701C1.13938 7.8701 1.13938 7.87017 1.13938 7.87025C1.13938 7.87027 1.13938 7.87035 1.13938 7.8704C1.13938 7.8705 1.13938 7.8706 1.13938 7.8707C1.13938 7.8709 1.13938 7.87111 1.13938 7.87131C1.13939 7.87173 1.13939 7.87214 1.1394 7.87257C1.13941 7.87342 1.13943 7.8743 1.13946 7.8752C1.13953 7.87701 1.13962 7.87896 1.13978 7.88103C1.14007 7.88512 1.14059 7.88995 1.14151 7.89535C1.14323 7.90545 1.14694 7.92115 1.15585 7.93861C1.16508 7.95672 1.18114 7.97896 1.20762 7.99626C1.2349 8.01409 1.26428 8.02081 1.29011 8.02081V7.72081ZM1.43197 7.82354C0.623164 5.34647 1.53102 2.26869 4.3994 1.36184L4.30896 1.0758C1.23531 2.04755 0.302663 5.33142 1.14679 7.91665L1.43197 7.82354ZM4.39955 1.36179C5.7527 0.932384 7.22762 1.12136 8.42 1.85949L8.57791 1.60441C7.31141 0.820401 5.74571 0.619858 4.30881 1.07585L4.39955 1.36179ZM8.57801 1.85943C9.73213 1.14371 11.2694 0.945205 12.5951 1.36192L12.685 1.07572C11.2763 0.632908 9.64845 0.842602 8.4199 1.60447L8.57801 1.85943ZM12.5948 1.36184C15.4664 2.27018 16.3769 5.34745 15.5689 7.82356L15.8541 7.91663C16.6975 5.33188 15.7617 2.04893 12.6853 1.07581L12.5948 1.36184ZM15.5686 7.8243C14.9453 9.76841 13.2952 11.4801 11.7526 12.7288C10.2142 13.974 8.80513 14.7411 8.69378 14.8011L8.83606 15.0652C8.9555 15.0009 10.3826 14.2236 11.9413 12.9619C13.4957 11.7037 15.2034 9.94602 15.8543 7.91589L15.5686 7.8243ZM8.69334 14.8013C8.6337 14.8337 8.56752 14.85 8.50115 14.85V15.15C8.61648 15.15 8.73201 15.1217 8.83649 15.065L8.69334 14.8013Z" fill="currentColor"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8384 6.93209C12.5548 6.93209 12.3145 6.71865 12.2911 6.43693C12.2427 5.84618 11.8397 5.34743 11.266 5.1656C10.9766 5.07361 10.8184 4.76962 10.9114 4.48718C11.0059 4.20402 11.3129 4.05023 11.6031 4.13934C12.6017 4.45628 13.3014 5.32371 13.3872 6.34925C13.4113 6.64606 13.1864 6.90622 12.8838 6.92993C12.8684 6.93137 12.8538 6.93209 12.8384 6.93209Z" fill="currentColor"/>
                                    <path d="M12.8384 6.93209C12.5548 6.93209 12.3145 6.71865 12.2911 6.43693C12.2427 5.84618 11.8397 5.34743 11.266 5.1656C10.9766 5.07361 10.8184 4.76962 10.9114 4.48718C11.0059 4.20402 11.3129 4.05023 11.6031 4.13934C12.6017 4.45628 13.3014 5.32371 13.3872 6.34925C13.4113 6.64606 13.1864 6.90622 12.8838 6.92993C12.8684 6.93137 12.8538 6.93209 12.8384 6.93209" stroke="currentColor" stroke-width="0.3"/>
                                </svg>
                                اضافه به علاقه مندی ها
                            </a>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
