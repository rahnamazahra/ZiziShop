<x-panel.div-section id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <x-panel.div-section class="aside-logo flex-column-auto" id="kt_aside_logo">

        <x-panel.link href="#">
            <x-panel.div-section class="flex justify-start">
                <x-panel.image src="/images/logo/logo.png" class="h-25px logo" />
                <x-panel.span class="text-white">
                    مدیریت زی زی شـــاپ
                </x-panel.span>
            </x-panel.div-section>
        </x-panel.link>

        <x-panel.div-section id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <x-svg.icon-svg icon='arrow' class="svg-icon-1 rotate-180"/>
        </x-panel.div-section>

    </x-panel.div-section>

    <x-panel.div-section class="aside-menu flex-column-fluid">
        <x-panel.div-section class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <x-panel.div-section class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">

                //TODO:DRY Don't Repeat Yourself

                <x-panel.menu-item href="{{ route('admin.dashboard') }}" route="admin.dashboard" icon="dashbord" title="داشبورد‌"/>

                <x-panel.menu-item href="{{ route('admin.users.index') }}" route="admin.users.index" icon="user" title="مدیریت کاربران"/>

                <x-panel.menu-item href="{{ route('admin.categories.index') }}" route="admin.categories.index" icon="category" title="مدیریت دسته‌بندی"/>

                <x-panel.menu-item href="{{ route('admin.products.index') }}" route="admin.products.index" icon="product" title="مدیریت محصولات"/>
            </x-panel.div-section>
        </x-panel.div-section>
    </x-panel.div-section>
</x-panel.div-section>
