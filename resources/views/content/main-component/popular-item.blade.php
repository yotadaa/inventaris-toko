@php
    $popularItems = $transactions
        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        ->sortByDesc('qty')
        ->take(5);
@endphp

<div class="col-12">
    <div class="card top-selling overflow-auto">

        <?php
        $cat = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
        ?>
        <div class="card-body pb-0">
            <h5 class="card-title">Item Terpopuler Minggu Ini</h5>

            <table id='item-container' class="table table-hover" style="width: 100%">
                <thead>
                    <tr>
                        <th>Preview</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Keluar</th>
                        <th>Pendapatan</th>
                    </tr>
                </thead>
                <tbody style="width: 100%">
                    {{-- @php
                        $pp = $popularItems->groupBy('kode');
                    @endphp
                    <script>
                        console.log('popular')
                        console.log(@json($pp))
                    </script> --}}
                    @foreach ($popularItems->groupBy('kode') as $item)
                        <tr style="width: 100">
                            <td>
                                <img src="{{ $item->first()->foto }}" width='50' class=""
                                    style="border-radius: 5px; border: 1px solid darkgray">
                            </td>
                            <td>{{ $item->first()->nama }}</td>
                            <td>{{ $cat[$item->first()->kategori] }}</td>
                            <td class="data-numeric
                                    text-center">
                                {{ $item->sum('qty') }}
                            </td>
                            <td class="data-numeric text-center text-success">
                                <span class="fw-bold" style="display: flex; justify-content: center; "><span>
                                    </span><span>Rp
                                        {{ number_format($item->sum('qty') * $item->sum('harga_jual')) }}</span></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</div>
