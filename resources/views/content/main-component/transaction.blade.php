@php
    $transactionTrack = $transactions->sortByDesc('created_at')->take(10);
@endphp

<div class="col-12">
    <div class="card recent-sales overflow-auto">
        <?php
        $cat = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
        ?>
        <div class="card-body">
            <h5 class="card-title">Transaksi Terakhir</span></h5>

            <table id='item-container' class="table table-borderless table-hover" style="width: 100%">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Keluar</th>
                        <th>Pendapatan</th>
                        <th>Bersih</th>
                    </tr>
                </thead>
                <tbody style="width: 100%">
                    @foreach ($transactionTrack as $item)
                        <tr style="width: 100" id='row{{ $item->kode }}'>

                            <td style='max-width: 100px;'>{{ $item->kode }}</td>
                            {{-- <td>
                                <img src="{{ $item->foto }}" width="30"
                                    alt='preview-{{ $item->kode }}' />
                            </td> --}}
                            <td>{{ $item->nama }}</td>
                            <td>{{ $cat[$item->kategori] }}</td>
                            <td class="data-numeric text-center">{{ $item->qty }}</td>
                            <td class="data-numeric text-center" style=''>
                                <span style="display: flex; justify-content: space-between;"><span>Rp
                                    </span><span>{{ $item->qty * $item->harga_jual }}</span></span>
                            </td>
                            <td class="data-numeric text-center">
                                <span class="badge bg-success "
                                    style="display: flex; justify-content: space-between; font-weight: 600"><span
                                        style="color:white;">Rp</span><span
                                        style="color:white;">{{ $item->qty * $item->harga_jual - $item->qty * $item->harga_awal }}</span></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</div>
