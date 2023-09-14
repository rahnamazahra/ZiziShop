@props(['headers', 'data'])

<div class="table-responsive">
    <table class="table table-striped gy-7 gs-7">
        <thead>
            <tr>
                @foreach ($headers as $header)
                    <th class="text-center">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $item }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="{{ count($headers) }}">آیتمی برای نمایش وجود ندارد.</td>

                </tr>
            @endforelse
        </tbody>
    </table>
</div>
