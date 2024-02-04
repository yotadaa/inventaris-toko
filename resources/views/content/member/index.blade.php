@if (Auth::check())
    @if (Auth::user()->role != 'super')
        <script>
            window.location.href = '/'
        </script>
    @endif
@else
    <script>
        window.location.href = '/session'
    </script>
@endif

@extends('layout.index')
@section('title')
    About | PlinPlan
@endsection
@section('body')
    <script>
        document.querySelector('#components-nav').classList.remove('collapse');
        document.querySelector('#components-nav').classList.add('show');
        document.querySelector('#member').classList.remove('collapsed');
        var cats = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
    </script>
    <section class="section">

        <div class="card">
            <div class="card-body overflow-auto">
                <div class="card-title">
                    <nav class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Member</li>
                        </ol>
                    </nav>
                    Daftar Member
                    <div class="text-muted small" style="font-size:;">
                    </div>
                </div>
                <section class="section">
                    <div class="d-block d-md-flex" style='gap: 10px'>
                        <div class='d-flex' style="gap: 10px; margin-bottom: 10px;">
                            <button style="display: flex; align-items: center; gap: 5px;" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#tambah-rencana" onclick="testFunc(event)">
                                <strong><i class="bi bi-box-arrow-in-down"></i></strong>
                                Tambah Member</button>
                        </div>
                </section>
                <div class="border-bottom"></div>
                <section class="section overflow-auto" style='overflow-x: scroll'>

                    <div class="small text-danger">**Klik Selesai tombol dua kali</div>
                    {{-- @if ($rencana->count() == 0)
                        <div class="text-center mt-3">
                            Belum ada daftar member di tokomu
                        </div>
                    @else
                        <table id='items-container' class="table datatable table-borderless table-striped table-hover"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Grup</th>
                                    <th>Waktu</th>
                                    <th class="text-center">Jumlah Item</th>
                                    <th class="text-center">Total</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                        </table>
                    @endif --}}
                </section>
            </div>
        </div>
    </section>
@endsection
