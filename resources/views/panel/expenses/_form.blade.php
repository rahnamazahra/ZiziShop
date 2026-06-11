@php $e = $expense ?? null; @endphp
<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label required">عنوان هزینه</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $e->title ?? '') }}" required>
        <x-form.input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div class="col-md-6">
        <label class="form-label required">نوع هزینه</label>
        <select name="type" class="form-select" required>
            @foreach($types as $t)
                <option value="{{ $t->value }}" @selected(old('type', $e->type->value ?? '') === $t->value)>{{ $t->label() }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label required">مبلغ (تومان)</label>
        <input type="number" name="amount" class="form-control" value="{{ old('amount', $e->amount ?? '') }}" min="0" required>
        <x-form.input-error :messages="$errors->get('amount')" class="mt-2" />
    </div>

    <div class="col-md-4">
        <label class="form-label required">تاریخ پرداخت</label>
        <input type="date" name="spent_at" class="form-control" value="{{ old('spent_at', optional($e?->spent_at)->format('Y-m-d')) }}" required>
        <div class="text-muted fs-8 mt-1">به‌صورت شمسی نمایش داده می‌شود.</div>
    </div>

    <div class="col-md-4">
        <label class="form-label required">تناوب</label>
        <select name="recurrence" class="form-select" required>
            @foreach($recurrences as $key => $label)
                <option value="{{ $key }}" @selected(old('recurrence', $e->recurrence ?? 'once') === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">توضیحات</label>
        <textarea name="description" class="form-control" rows="2">{{ old('description', $e->description ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <div class="separator my-2"></div>
        <div class="text-muted fs-7 mb-2">مخصوص «خرید اجناس / متریال» (اختیاری):</div>
    </div>

    <div class="col-md-4">
        <label class="form-label">نام متریال</label>
        <input type="text" name="material_name" class="form-control" value="{{ old('material_name', $e->material_name ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">کد محصول</label>
        <input type="text" name="product_code" class="form-control" value="{{ old('product_code', $e->product_code ?? '') }}">
    </div>
    <div class="col-md-2">
        <label class="form-label">تعداد</label>
        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $e->quantity ?? '') }}" min="0">
    </div>
    <div class="col-md-3">
        <label class="form-label">وزن (گرم)</label>
        <input type="number" name="weight" class="form-control" value="{{ old('weight', $e->weight ?? '') }}" min="0">
    </div>

    <div class="col-12">
        <x-demo-checkbox :checked="old('is_demo', $e->is_demo ?? false)" />
    </div>
</div>
