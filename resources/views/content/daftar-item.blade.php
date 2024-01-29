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

                            <ul class="dropdown-menu dropdown-menu-start">
                                <li class="">
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="bi bi-caret-right-fill"></i>
                                        <span style='display: flex; justify-content: space-between; width: 100%'>
                                            Makanan
                                            <span class="badge bg-secondary text-light">
                                                {{ $items->where('kategori', 0)->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="">
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="bi bi-caret-right-fill"></i>
                                        <span style='display: flex; justify-content: space-between; width: 100%'>
                                            Minuman
                                            <span class="badge bg-secondary text-light">
                                                {{ $items->where('kategori', 1)->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="">
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="bi bi-caret-right-fill"></i>
                                        <span style='display: flex; justify-content: space-between; width: 100%'>Rokok
                                            <span class="badge bg-secondary text-light">
                                                {{ $items->where('kategori', 2)->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>


                                <li class="">
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="bi bi-caret-right-fill"></i>
                                        <span style='display: flex; justify-content: space-between; width: 100%'>
                                            Lainnya
                                            <span class="badge bg-secondary text-light">
                                                {{ $items->where('kategori', 3)->count() }}
                                            </span>
                                        </span>
                                    </a>
                                </li>

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
                        <table class="table datatable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
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
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td style="max-width: 300px; white-space: pre-wrap">{{ $item->desk }}</td>
                                        <td>{{ $cat[$item->kategori] }}</td>
                                        <td class="data-numeric">{{ $item->stok }}</td>
                                        <td class="data-numeric">{{ $item->harga_awal }}</td>
                                        <td class="data-numeric">{{ $item->harga_jual }}</td>
                                        <td class="d-block d-md-flex">
                                            {{-- <div style="scale: 0.8" class="btn-group" role="group"
                                                aria-label="Basic mixed styles example"> --}}
                                            <button style="scale: 0.8" title='Detail' type='button'
                                                class="btn shadow border btn-secondary"><i
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
                        <!-- End Table with stripped rows -->

                    </div>
                </div>
            </div>
        </div>
        </div>


    </section>
    <script>
        document.querySelector('#components-nav').classList.remove('collapse');
        document.querySelector('#kelola-list').classList.remove('collapsed');
        document.querySelector('#daftar-item').classList.add("active");
    </script>
@endsection
