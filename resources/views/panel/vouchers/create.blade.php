@extends('layouts.panel.master')

@section('title', 'کوپن')

@section('breadcrumb')
    <x-panel.breadcrumb :breadcrumb="['داشبورد' => route('admin.dashboard'), 'کوپن' => route('admin.vouchers.index'), 'ایجاد رنگ' => route('admin.vouchers.create')]" title='کاربران' />
@endsection

@section('content')
    <x-form method="POST" :action="route('admin.vouchers.store')">
        <x-panel.card>

            <x-panel.card-header>
                <x-panel.card-title>
                   <x-panel.heading level="1"> ایجاد کوپن جدید</x-panel.heading>
                </x-panel.card-title>
            </x-panel.card-header>

            <x-panel.card-body>
                <x-panel.row>
                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="code" class="required">کد تخفیف</x-form.label>
                        <x-form.input type="text" name="code" value="{{ old('code') }}"/>
                        <x-form.input-error :messages="$errors->get('code')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="discount" class="">میزان تخفیف</x-form.label>
                        <x-form.input type="discount"  name="discount" value="{{ old('discount') }}"/>
                        <x-form.input-error :messages="$errors->get('discount')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="start_date" class="">تاریخ شروع تخفیف</x-form.label>
                        <x-form.input type="start_date"  id="input_date" name="start_date" value="{{ old('start_date') }}" data-jdp/>
                        <span id="calendar"></span>
                        <x-form.input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="end_date" class="">تاریخ پایان تخفیف</x-form.label>
                        <x-form.input type="end_date"  id="input_date" name="end_date" value="{{ old('end_date') }}" data-jdp/>
                        <span id="calendar"></span>
                        <x-form.input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="shipping_discount" class="required">تخفیف پستی </x-form.label>
                        <x-form.input type="shipping_discount"  name="shipping_discount" value="{{ old('shipping_discount') }}"/>
                        <x-form.input-error :messages="$errors->get('shipping_discount')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="mininum_purchase_total" class="">حداقل مبلغ خرید</x-form.label>
                        <x-form.input type="mininum_purchase_total"  name="mininum_purchase_total" value="{{ old('mininum_purchase_total') }}"/>
                        <x-form.input-error :messages="$errors->get('mininum_purchase_total')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="maximum_discount" class="">حداکثر مبلغ تخفیف</x-form.label>
                        <x-form.input type="maximum_discount"  name="maximum_discount" value="{{ old('maximum_discount') }}"/>
                        <x-form.input-error :messages="$errors->get('maximum_discount')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="maximum_shipping_discount" class="">حداکثر تخفیف پست</x-form.label>
                        <x-form.input type="maximum_shipping_discount" name="maximum_shipping_discount" value="{{ old('maximum_shipping_discount') }}"/>
                        <x-form.input-error :messages="$errors->get('maximum_shipping_discount')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="remaining" class="">باقیمانده</x-form.label>
                        <x-form.input type="remaining" name="remaining" value="{{ old('remaining') }}"/>
                        <x-form.input-error :messages="$errors->get('remaining')" class="mt-2" />
                    </x-panel.div-section>

                    <x-panel.div-section class="col-md-6">
                        <x-form.label id="comment" class="">توضیحات</x-form.label>
                        <x-form.input type="comment" name="comment" value="{{ old('comment') }}"/>
                        <x-form.input-error :messages="$errors->get('comment')" class="mt-2" />
                    </x-panel.div-section>
                </x-panel.row>
            </x-panel.card-body>

            <x-panel.card-footer>
                <x-panel.div-section class="d-flex justify-content-end">

                    <x-form.btn-a :href="route('admin.vouchers.index')" class="btn-light me-3" title="لغو">
                        لغو
                    </x-form.btn-a>

                    <x-form.btn type="submit" class="btn-primary" title="ثبت">
                        ثبت
                    </x-form.btn>

                </x-panel.div-section>
            </x-panel.card-footer>

        </x-panel.card>
    </x-form>
@endsection


@section('custom-scripts')
    <script>
        jalaliDatepicker.startWatch();
    </script>
@endsection
