@props(['checked' => false])

<div class="card mt-5" style="border:1px dashed #ffc107;background:#fffdf5;">
    <div class="card-body py-4">
        <label class="form-check form-check-custom d-flex align-items-start gap-2" style="cursor:pointer;">
            <input type="hidden" name="is_demo" value="0">
            <input class="form-check-input" type="checkbox" name="is_demo" value="1" @checked($checked)>
            <span class="form-check-label">
                <strong>این یک مورد تستی / نمایشی است.</strong>
                <span class="text-muted fs-8 d-block mt-1">فقط زمانی که ادمین «نمایش موارد تستی» را روشن کند دیده می‌شود و هرگز در محاسبات واقعی یا برای مشتری لحاظ نمی‌شود.</span>
            </span>
        </label>
    </div>
</div>
