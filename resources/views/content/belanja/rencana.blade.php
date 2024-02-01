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

    <section class="section">

        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <nav class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('belanja') }}">Belanja</a></li>
                            <li class="breadcrumb-item active">Rencana Belanja</li>
                        </ol>
                    </nav>
                    Daftar Rencana Belanja
                    <div class="text-muted small" style="font-size:;">
                        @if ($rencana->count() == 0)
                            Kamu tidak punya rencana belanja
                        @else
                            Kamu punya {{ $rencana->count() }} rencana belanja
                        @endif
                    </div>
                </div>
                <section class="section">
                    <div class="d-block d-md-flex" style='gap: 10px'>
                        <div class='d-flex' style="gap: 10px; margin-bottom: 10px;">
                            <a href="/belanja/rencana" style="display: flex; align-items: center; gap: 5px;"
                                class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-rencana">
                                <strong><i class="bi
                                bi-box-arrow-in-down"></i></strong>
                                Tambah Daftar</a>
                        </div>
                </section>
                <div class="border-bottom"></div>
                <section class="section">
                    @if ($rencana->count() == 0)
                        <div class="text-center mt-3">
                            Belum ada daftar rencana
                        </div>
                    @else
                        <table id='item-container' class="table table-borderless table-striped table-hover"
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
                            {{-- @php
                                $groupedRencana = $rencana // there are item like [1,1,1,2,2,3], get the unique row
                            @endphp --}}
                            <tbody>
                                @foreach ($rencana->unique('group') as $item)
                                    <tr>
                                        <td style="vertical-align: middle" class="text-center">{{ $item->group }}</td>
                                        <td style="vertical-align: middle">
                                            {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY [pukul] H:mm:ss') }}
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            {{ $rencana->where('group', $item->group)->count() }}
                                        </td>
                                        <td style="vertical-align: middle" class="text-center">
                                            <span class="badge bg-danger">Rp
                                                {{ $rencana->where('group', $item->group)->sum(function ($row) {
                                                    return $row->qty * $row->harga_awal;
                                                }) }}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle">
                                            <button class="btn btn-secondary"><i class="bi bi-eye"></i></button>
                                            <button
                                                @if ($item->status == 0) class="btn btn-secondary"
                                            @else class="btn btn-success" @endif>Selesai</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </section>
            </div>
        </div>
    </section>

    @include('content.belanja.tambah-rencana')
@endsection
