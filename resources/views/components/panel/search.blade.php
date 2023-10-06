<x-form.layout method="GET" action="{{ $action }}">
    <x-panel.div-section class="input-group input-group-sm input-group-solid">
        <x-form.btn type="submit" class="input-group-text btn-sm" title="جست‌و‌جو">
            <x-svg.icon-svg icon='search'/>
        </x-form.btn>
        <x-form.input type="text" class="form-control form-control-solid" placeholder="جست و جو ..." name="search" value=""/>
    </x-panel.div-section>
</x-form.layout>
