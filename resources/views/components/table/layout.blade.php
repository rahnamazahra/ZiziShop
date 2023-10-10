@props(['headers', 'data', 'actions'])

<x-panel.div-section class="table-responsive">
    <x-table.table>
        <x-table.thead>

            <x-table.tr>

                @foreach ($headers as $header => $value)
                    <x-table.th>{{ $header }}</x-table.th>
                @endforeach

                @foreach($data  as $item)
                    @if($item->files)
                        <x-table.th>عکس</x-table.th>
                    @endif
                @endforeach

                <x-table.th>اقدامات</x-table.th>

            </x-table.tr>

        </x-table.thead>
        <x-table.tbody>

            @forelse ($data as $key => $item)
                <x-table.tr>

                    @foreach ($headers as $header => $key)
                        <x-table.td>{{ $item->$key ?? '-' }}</x-table.td>
                    @endforeach

                    @foreach($data  as $item)
                        @if($item->files)
                        <x-table.td>
                            @foreach($item->files as $file)
                                <a class="symbol" href="">
                                    <image class="symbol-label" style="width:50px;height:50px" src="{{ asset('/upload/'. $file->path) }}" />
                                </a>
                                @endforeach
                        </x-table.td>
                        @endif
                    @endforeach

                    <x-table.td class="text-center">
                        @foreach ($actions as $action)
                            @if ($action['method'] == 'DELETE')

                                <x-form.layout method="DELETE" :action="route($action['route'], $item)">
                                    <x-form.btn type="submit" class="btn-light btn-icon btn-bg-light btn-sm me-1" title="{{ $action['title'] }}">
                                        <x-svg.icon-svg icon='{{ $action["icon"] }}' />
                                    </x-form.btn>
                                </x-form.layout>

                            @else

                                <x-form.btn-a :href="route($action['route'], $item)" class="btn-light btn-icon btn-bg-light btn-sm me-1" title="{{ $action['title'] }}">
                                        <x-svg.icon-svg icon='{{ $action["icon"] }}' />
                                </x-form.btn-a>

                            @endif
                        @endforeach
                    </x-table.td>
                </x-table.tr>

            @empty

                <x-table.tr>
                    <x-table.td colspan="{{ count($headers) + 1 }}">آیتمی برای نمایش وجود ندارد.</x-table.td>
                </x-table.tr>

            @endforelse

        </x-table.tbody>
    </x-table.table>
</x-panel.div-section>
