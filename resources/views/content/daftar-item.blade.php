@extends('layout.index')
@section('title')
    Daftar Barang
@endsection

@section('misc')
    @include('no-reload.head')
    <style>
        .data-numeric {
            text-align: right;
        }
    </style>
@endsection
@section('body')
    <?php
    $cat = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
    ?>
    <section class="section">
        <div class="" style="background-color: white; box-shadow: 0px 0px 10px rgba(0,0,0,0.2); border-radius: 10px">
            <div class=" recent-sales">
                <div class="card-body">
                    <h5 class="card-title">Daftar Barang<br>
                        <span class="text-muted small">
                            @if (count($items) > 0)
                                Terdapat {{ count($items) }}
                                barang di inventaris
                            @else
                                Belum ada barang di inventaris
                            @endif
                        </span>
                    </h5>
                    <div style='display: flex; gap: 10px'>
                        <button style="display: flex; align-items: center; gap: 5px;" type="button" class="btn btn-primary">
                            <strong><i class="bi bi-box-arrow-in-down"></i></strong>
                            Tambah</button>
                        <div class="dropdown">

                            <a class=" btn btn-outline-primary d-flex align-items-center" data-bs-toggle="dropdown">

                                <i class="d-md-none d-block bi bi-funnel-fill"></i>
                                <span class="d-none d-md-block dropdown-toggle">
                                    Kategori
                                </span>
                            </a><!-- End Profile Iamge Icon -->

                            <ul class="dropdown-menu dropdown-menu-start" id='category-list'>
                                <li class="">
                                    <button class="dropdown-item d-flex align-items-center" onclick="changeCategory(-1)">
                                        <i class="bi bi-caret-right-fill"></i>
                                        <span style='display: flex; justify-content: space-between; width: 100%'>
                                            Semua
                                            <span class="badge bg-secondary text-light">
                                                {{ $items->count() }}
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
                                                    {{ $items->where('kategori', $i)->count() }}
                                                </span>
                                            </span>
                                        </button>
                                    </li>
                                @endfor

                            </ul><!-- End Profile Dropdown Items -->
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

                    <div class="card-body text-muted small" style='padding-top: 20px;'>
                        <!-- Table with stripped rows -->
                        <table class="table datatable table-borderless table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Harga Awal</th>
                                    <th>Harga Jual</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody style="width: 100%">
                                @foreach ($items as $item)
                                    <tr style="width: 100%">
                                        <td>{{ $item->kode }}</td>
                                        {{-- <td>
                                            <img src="{{ $item->foto }}" width="30"
                                                alt='preview-{{ $item->kode }}' />
                                        </td> --}}
                                        <td>{{ $item->nama }}</td>
                                        <td style="max-width: 300px; white-space: pre-wrap">{{ $item->desk }}</td>
                                        <td>{{ $cat[$item->kategori] }}</td>
                                        <td class="data-numeric">{{ $item->stok }}</td>
                                        <td class="data-numeric">{{ $item->harga_awal }}</td>
                                        <td class="data-numeric">{{ $item->harga_jual }}</td>
                                        <td class="d-block d-md-block d-lg-flex" style='height: 100%'>
                                            {{-- <div style="scale: 0.8" class="btn-group" role="group"
                                                aria-label="Basic mixed styles example"> --}}
                                            <button style="scale: 0.8" title='Detail' type='button'
                                                class="btn shadow border btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#detail-modal"
                                                onclick="openDetailModal({{ $item }})"><i
                                                    class="bi bi-info-circle"></i></button>
                                            <button style="scale: 0.8" title='Edit' type='button'
                                                class="btn shadow border btn-warning"><i
                                                    class="bi bi-pencil-square"></i></button>
                                            <button style="scale: 0.8" title='Hapus' type='button'
                                                class="btn shadow border btn-danger"><i class="bi bi-trash"></i></button>
                                            {{-- </div> --}}
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
    <div style="box-shadow: 0 0 15px rgba(0,0,0,0.4)" class="modal fade shadow" id="detail-modal" tabindex="-1"
        data-bs-backdrop="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="display: flex; align-items: center; gap: 10px;" class="modal-title"><i
                            class="bi bi-info-circle"></i>
                        Detail Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="width: 100%; display: flex; justify-content: center;align-items:center">
                    <form class="row g-3" style="">
                        <div style='display: flex; align-items: center; justify-content: center; '>
                            <img id='foto-brg' width="200" style="border-radius: 5px; border: 1px solid darkgray"
                                class="shadow">
                        </div>

                        <div class="d-block d-md-flex" style="width: 100%;flex-direction: row; gap: 10px;">
                            <div style="width: 100%">
                                <div class="col-12">
                                    <label class="form-label">Nama Barang</label>
                                    <input disabled='true' type="text" class="form-control" id="nama-brg">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Kategori</label>
                                    <input disabled='true' type="text" class="form-control" id="kategori-brg">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Stok</label>
                                    <input disabled='true' type="number" class="form-control" id="stok-brg">
                                </div>
                            </div>
                            <div style="width: 100%">
                                <div class="col-12">
                                    <label class="form-label">Harga Awal</label>
                                    <input disabled='true' type="number" class="form-control" id="hrg-awl-brg"
                                        placeholder="1234 Main St">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Harga Jual</label>
                                    <input disabled='true' type="number" class="form-control" id="hrg-jual-brg"
                                        placeholder="1234 Main St">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea disabled='true' type="text" class="form-control" id="desk-brg" placeholder="1234 Main St"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning"><i class="bi bi-pencil-square"></i>Edit</button>
                    <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i>Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('#components-nav').classList.remove('collapse');
        document.querySelector('#kelola-list').classList.remove('collapsed');
        document.querySelector('#daftar-item').classList.add("active");
        var cats = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];

        function openDetailModal(item) {
            document.querySelector('#foto-brg').src = item.foto;
            document.querySelector('#nama-brg').value = item.nama;
            document.querySelector('#kategori-brg').value = item.kategori;
            document.querySelector('#hrg-awl-brg').value = item.harga_awal;
            document.querySelector('#hrg-jual-brg').value = item.harga_jual;
            document.querySelector('#desk-brg').value = item.desk;
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
@endsection
