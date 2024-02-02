@extends('layout.index')
@section('title')
    Belanja
@endsection

@section('misc')
    @include('no-reload.head')
    <style>
        .data-numeric {
            text-align: right;
        }

        .bg-fade {
            background-color: rbga(0, 0, 0, 1)
        }
    </style>
@endsection
@section('body')
    @include('no-reload.body-up')
    <?php
    $cat = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
    ?>
    <script>
        var currentItem = {
            nama: '',
            kode: '',
            foto: '',
            terjual: '',
            pendapatan: '',
            waktu: ''
        }
    </script>
    <section class="section">
        <div class="" style="background-color: white; box-shadow: 0px 0px 10px rgba(0,0,0,0.2); border-radius: 10px">
            <div class=" recent-sales">
                <div class="card-body">
                    <div class="card-title">
                        <nav class="">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                <li class="breadcrumb-item active">Belanja</li>
                            </ol>
                        </nav>
                        Belanja<br>
                        <span class="text-muted small">
                            @if ($belanja->count() > 0)
                                Terdapat total
                                {{ $belanja->count() }}
                                Transaksi {{ $periode }}
                            @else
                                Belum ada belanja {{ $periode }}
                            @endif

                        </span>
                    </div>
                    <div class="d-block d-md-flex" style='gap: 10px'>
                        {{-- <a href='{{ route('tambah-item') }}' style="display: flex; align-items: center; gap: 5px;"
                            type="button" class="btn btn-primary">
                            <strong><i class="bi bi-box-arrow-in-down"></i></strong>
                            Tambah</a> --}}
                        <div class='d-flex' style="gap: 10px; margin-bottom: 10px;">
                            <a href="/belanja/rencana" style="display: flex; align-items: center; gap: 5px;"
                                class="btn btn-primary">
                                <strong><i class="bi
                                bi-box-arrow-in-down"></i></strong>
                                Buat Daftar</a>
                            <div class="dropdown">

                                <a class=" btn btn-outline-primary d-flex align-items-center" data-bs-toggle="dropdown">

                                    <i class="d-md-none d-block bi bi-funnel-fill"></i>
                                    <span class="d-none d-md-block dropdown-toggle">
                                        Kategori
                                    </span>
                                </a><!-- End Profile Iamge Icon -->

                                <ul class="dropdown-menu dropdown-menu-start" id='category-list'>
                                    <li class="">
                                        <button class="dropdown-item d-flex align-items-center"
                                            onclick="changeCategory(-1)">
                                            <i class="bi bi-caret-right-fill"></i>
                                            <span style='display: flex; justify-content: space-between; width: 100%'>
                                                Semua
                                                <span class="badge bg-secondary text-light">
                                                    {{ $belanja->count() }}
                                                </span>
                                            </span>
                                        </button>
                                    </li>
                                    @for ($i = 0; $i < 4; $i++)
                                        <li class="">
                                            <button class="dropdown-item d-flex align-items-center"
                                                onclick="changeCategory({{ $i }})">
                                                <i class="bi bi-caret-right-fill"></i>
                                                <span style='display: flex; justify-content: space-between; width: 100%'>
                                                    {{ $cat[$i] }}
                                                    <span class="badge bg-secondary text-light">
                                                        {{ $belanja->where('kategori', $i)->count() }}
                                                    </span>
                                                </span>
                                            </button>
                                        </li>
                                    @endfor

                                </ul><!-- End Profile Dropdown Items -->
                            </div>
                        </div>

                        <div class="btn-group" role="group" aria-label="Basic outlined example"
                            style="margin-bottom: 10px">
                            <a id='day'
                                class="btn btn-outline-secondary @if ($periode == 'Hari ini') active" href='#' @else " href='/transaksi?period=day' @endif>Hari
                                Ini</a>
                            <a id='week' class="btn
                                btn-outline-secondary
                                @if ($periode == 'Minggu ini') active" href='#' @else " href='/transaksi?period=week' @endif>Minggu</a>
                            <a id='month'
                                class="btn btn-outline-secondary @if ($periode == 'Bulan ini') active" href='#' @else " href='/transaksi?period=month' @endif>Bulan Ini</a>
                            <a id='alltime' class="btn
                                btn-outline-secondary
                                @if ($periode == '') active" href='#' @else " href='/transaksi' @endif>All
                                time</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class='section'>
        <div class="row">
            <div class="col-lg-12">
                <div class="card" style='margin-top: 20px;'>

                    <div class="card-body text-muted small overflow-auto" style='padding-top: 20px;'>
                        <!-- Table with stripped rows -->
                        <table id='item-container' class="table datatable table-borderless table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Masuk</th>
                                    <th>Pengeluaran</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody style="width: 100%">
                                @foreach ($belanja->sortByDesc('created_at') as $item)
                                    <tr style="width: 100" id='row{{ $item->kode }}'>

                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
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
                                        <td>
                                            <div class="d-block d-md-block d-lg-flex"
                                                style='height: 100%; align-items:center'>
                                                <button onclick="openDetailModal({{ json_encode($item) }})"
                                                    style="scale: 0.8" title='Detail' type='button'
                                                    class="btn shadow border btn-secondary shadow" data-bs-toggle="modal"
                                                    data-bs-target="#detail-modal"><i
                                                        class="bi bi-info-circle"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    {{-- @include('content.transaksi.tambah-modal') --}}

    @include('content.belanja.detail')
    <script>
        document.querySelector('#components-nav').classList.remove('collapse');
        document.querySelector('#components-nav').classList.add('show');
        document.querySelector('#kelola-list').classList.remove('collapsed');
        document.querySelector('#belanja').classList.add("active");
        var cats = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];



        function openDetailModal(item) {
            console.log(item)
            document.querySelector('#foto-brg').src = item.foto;
            document.querySelector('#nama-brg').value = item.nama;
            document.querySelector('#kategori-brg').value = cats[item.kategori];
            document.querySelector('#pendapatan-brg').value = 'Rp. ' + (item.qty * item.harga_jual);
            document.querySelector('#keluar-brg').value = item.qty;
            @if ($belanja->count() > 0)
                document.querySelector('#waktu-brg').value =
                    "{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY [pukul] H:mm:ss') }}";
            @else
                document.querySelector('#waktu-brg').value = "";
            @endif
        }

        function changeCategory(cat) {
            // Get all table rows
            var rows = document.querySelectorAll('.datatable tbody tr');
            if (cat === -1) {
                rows.forEach(function(row) {
                    row.style.display = 'table-row';
                });
                return;
            }

            // Loop through each row and check the category
            rows.forEach(function(row) {
                var categoryColumn = row.querySelector('td:nth-child(4)');
                // console.log(categoryColumn)
                // // Check if the category matches the selected category
                if (categoryColumn.textContent.trim() === cats[cat]) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
    <form method='post' id='deletion-value-form' action='{{ route('delete') }}' style="display: none;">
        @csrf @method('post')
        <input id='confirmed-email' name='confirmedEmail' value='' type='email'>
        <input id='confirmed-kode' name='confirmedKode' value='' type='number'>
    </form>
    <script>
        function deletionValue(kode, email) {
            console.log(kode + " dan " + email)
            document.querySelector('#confirmed-email').value = email;
            document.querySelector('#confirmed-kode').value = kode;
        }
    </script>
    <div class="modal fade" id="deleteItemConfirmation" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-body text-center">
                    Hapus barang? keputusan ini tidak dapat dibatalkan
                </div>
                <div class="text-center" style="gap: 10px;">
                    <button type="button" style="margin-right: 10px;" class="btn btn-secondary"
                        data-bs-dismiss="modal">Batal
                    </button>
                    <button type='button' onclick="deletionItemConfirmed()" style="margin-left: 10px;"
                        class="btn btn-primary">Hapus
                    </button>`
                </div>
            </div>
        </div>
        <script>
            function deletionItemConfirmed() {
                var form = document.getElementById('deletion-value-form');
                form.submit();
            }
        </script>
    </div>
    <script>
        function tambahDaftarBelanja() {
            $.ajax({
                url: '/tes',
                type: 'POST',
                data: {
                    test: [
                        value = 'success'
                    ]
                },
                success: function(res) {},
                error: function(err) {
                    console.error(err);
                }
            });
        }
    </script>
@endsection
