@props(['headers', 'data', 'actions'])

<x-panel.div-section class="table-responsive">
    <x-table.table>
        <x-table.thead>
            <x-table.tr>
                @foreach ($headers as $header => $value)
                    <x-table.th>{{ $header }}</x-table.th>
                @endforeach
            </x-table.tr>
        </x-table.thead>
        <x-table.tbody>
            @forelse ($data as $key => $item)
                <x-table.tr>
                    @foreach ($headers as $header => $value)
                        <x-table.th>{{ $item->$value }}</x-table.th>
                    @endforeach
                    <x-table.td class="text-center">
                        @if (isset($actions))
                            @foreach ($actions as $action)
                                <x-form.btn-a :route="route($action['route'], ['id' => $item['id']])" class="btn-light" title="{{ $action['title'] }}">
                                    <x-svg.icon-svg icon='{{ $action['icon'] }}' />
                                </x-form.btn-a>
                            @endforeach
                        @endif
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="{{ count($headers) }}">آیتمی برای نمایش وجود ندارد.</x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table.table>
</x-panel.div-section>
