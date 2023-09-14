<input type="{{ $type }}" {{ $attributes->merge(['class' => "form-control form-control-solid"]) }} name="{{ $name }}" value="{{ $value }}" />

                {{--  <div class="row g-9">

                    <div class="col-md-6 fv-row">
                        <label for="name" class="required form-label">نام</label>
                        <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name') }}" />
                    </div>

                    <div class="col-md-6 fv-row">
                        <label for="phone" class="required form-label">شماره موبایل</label>
                        <input type="text" class="form-control form-control-solid input-just-number" id="mobile" name="mobile" value="{{ old('mobile') }}"/>
                    </div>

                    <div class="col-md-6 fv-row">
                        <label for="password" class="required form-label">رمزعبور</label>
                        <input type="password" class="form-control form-control-solid" name="password" value="{{ old('password') }}" />
                    </div>

                    <div class="col-md-6 fv-row">
                        <label for="name" class="required form-label">تکرار رمزعبور</label>
                        <input type="password" class="form-control form-control-solid" name="name" value="{{ old('name') }}" />
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" id="add_permission_form_cancel" class="btn btn-light me-3">لغو</a>
                    <button type="submit" id="add_permission_form_submit" class="btn btn-primary">
                        <span class="indicator-label">ثبت</span>
                        <span class="indicator-progress">لطفا چند لحظه صبر کنید ...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>  --}}
