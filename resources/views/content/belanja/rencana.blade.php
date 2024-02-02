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
        document.querySelector('#components-nav').classList.remove('collapse');
        document.querySelector('#components-nav').classList.add('show');
        document.querySelector('#kelola-list').classList.remove('collapsed');
        document.querySelector('#belanja').classList.add("active");

        var currentGroup = {};
    </script>

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
                        @if ($rencana->unique('group')->count() == 0)
                            Kamu tidak punya rencana belanja
                        @else
                            Kamu punya {{ $rencana->unique('group')->count() }} rencana belanja
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
                                @foreach ($rencana->unique('group')->sortByDesc('created_at') as $item)
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
                                            <button
                                                onclick="detailRencana({{ json_encode($rencana->where('group', $item->group)) }})"
                                                class="btn btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#detail-rencana">
                                                <i class="bi bi-eye"></i></button>
                                            <button ondblclick="submitRencana(this)"
                                                @if ($item->status == 0) class="btn btn-warning"
                                            @else disabled='true' class="btn btn-success" @endif>Selesai</button>
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
    <script>
        function checkDetailItem(button) {
            var icon = button.querySelector('i');
            if (icon.classList.contains('bi-square')) {
                icon.classList.remove('bi-square')
                icon.classList.add('bi-check-lg')
                button.classList.remove('btn-danger')
                button.classList.add('btn-success')
            } else {

                icon.classList.add('bi-square')
                icon.classList.remove('bi-check-lg')
                button.classList.add('btn-danger')
                button.classList.remove('btn-success')
            }

            var row = button.parentNode.parentNode.querySelectorAll('td')[5]
            var id = Number(row.innerText)
            console.log(id)
            $.ajax({
                url: '/belanja/update-check',
                method: 'POST',
                data: {
                    id: id
                },
                success: (res) => {

                },
                error: (err) => {
                    console.error(err)
                }
            })
        }

        function detailRencana(item) {
            const keys = Object.keys(item)

            var table = document.querySelector('#detail-item-container').querySelector('tbody').querySelectorAll('tr')
            table.forEach(function(row) {
                var code = row.querySelector('td').innerText
                var td = row.querySelectorAll('td');
                keys.map((keys) => {
                    if (item[keys].kode === Number(code)) {
                        row.style.display = 'table-row'
                        // console.log(Object.keys(item[keys]))
                        console.log(item[keys].checked)
                        if (item[keys].checked === 1) {
                            console.log(td[4])
                            td[4].querySelector('button').querySelector('i').classList.remove('bi-square')
                            td[4].querySelector('button').querySelector('i').classList.add('bi-check-lg')
                            td[4].querySelector('button').classList.remove('btn-danger')
                            td[4].querySelector('button').classList.add('btn-success')
                        } else {
                            td[4].querySelector('button').querySelector('i').classList.add('bi-square')
                            td[4].querySelector('button').querySelector('i').classList.remove('bi-check-lg')
                            td[4].querySelector('button').classList.add('btn-danger')
                            td[4].querySelector('button').classList.remove('btn-success')
                        }
                    }
                });
            })
        }

        function submitRencana(button) {
            var uncle = button.parentNode.parentNode.querySelectorAll('td');

            $.ajax({
                url: '/belanja/submit-rencana',
                method: 'POST',
                data: {
                    kode: Number(uncle[0].innerText)
                },
                success: (res) => {
                    button.disabled = true;
                    button.classList.add('btn-success')
                    button.classList.remove('btn-warning')
                },
                error: (err) => {
                    console.error(err)
                }
            })
        }
    </script>

    @include('content.belanja.tambah-rencana')
    @include('content.belanja.detail-rencana')
@endsection
