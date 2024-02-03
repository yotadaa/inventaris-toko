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
    @php
        $testVar = 123;
    @endphp
    <script>
        document.querySelector('#components-nav').classList.remove('collapse');
        document.querySelector('#components-nav').classList.add('show');
        document.querySelector('#kelola-list').classList.remove('collapsed');
        document.querySelector('#belanja').classList.add("active");

        var currentGroup = {};
        var isDeleting = false
    </script>

    <section class="section">

        <div class="card">
            <div class="card-body overflow-auto">
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
                            <button style="display: flex; align-items: center; gap: 5px;" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#tambah-rencana" onclick="testFunc(event)">
                                <strong><i class="bi bi-box-arrow-in-down"></i></strong>
                                Tambah Daftar</button>
                        </div>
                </section>
                <div class="border-bottom"></div>
                <section class="section overflow-auto" style='overflow-x: scroll'>

                    <div class="small text-danger">**Klik Selesai tombol dua kali</div>
                    @if ($rencana->count() == 0)
                        <div class="text-center mt-3">
                            Belum ada daftar rencana
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
                                                onclick="detailRencana({{ $item->group }}, {{ json_encode($rencana->where('group', $item->group)) }})"
                                                class="btn btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#detail-rencana" style='scale: 0.9'>
                                                <i class="bi bi-eye"></i></button>
                                            @if ($user->role == 'super')
                                                <button style='scale: 0.9' ondblclick="submitRencana(this)"
                                                    @if ($item->status == 0) class="btn btn-warning"
                                            @else disabled='true' class="btn btn-success" @endif>
                                                    <span class="visually-hidden spinner-border spinner-border-sm"
                                                        role="status" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Loading...</span>
                                                    Selesai
                                                </button>
                                                <button id='button-delete-{{ $item->group }}' style='scale: 0.9'
                                                    ondblclick="hapusRencana({{ $item->group }})" class="btn btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                    <span class="visually-hidden spinner-border spinner-border-sm"
                                                        role="status" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Loading...</span>
                                                </button>
                                            @endif
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
        function testFunc(event) {
            console.log('{{ ++$testVar }}');
        }

        function hapusRencana(group) {
            var button = document.getElementById(`button-delete-${group}`);
            button.querySelector('span').classList.remove('visually-hidden');
            button.querySelector('i').classList.add('visually-hidden');
            var row = $('#items-container tbody tr').filter(function() {
                return $(this).find('td:eq(0)').text().trim() == group;
            });
            button.disabled = true;
            isDeleting = true;
            $.ajax({
                url: '/belanja/rencana/hapus',
                method: 'POST',
                data: {
                    group: group,
                    email: '{{ $user->email }}'
                },
                success: (res) => {
                    console.log(res)
                    if (res.success) {
                        // window.location.reload()
                        row.remove()
                    } else {}
                },
                error: (err) => {
                    console.error(err);
                }
            });
        }

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

            var row = button.parentNode.parentNode.querySelectorAll('td')[6]
            var id = Number(row.innerText)
            // console.log(id)
            $.ajax({
                url: '/belanja/update-check',
                method: 'POST',
                data: {
                    id: id
                },
                success: (res) => {
                    console.log(id)
                    console.log(res)
                    // console.log(res)
                },
                error: (err) => {
                    console.error(err)
                }
            })
        }

        function detailRencana(group, item) {
            document.querySelector('#detail-loading').style.display = 'block'
            var table = document.querySelector('#detail-item-container').querySelector('tbody')
                .querySelectorAll('tr')
            table.forEach(function(row) {
                var td = row.querySelectorAll('td');
                row.style.display = 'none'
                td[5].querySelector('button').querySelector('i').classList.add('bi-square')
                td[5].querySelector('button').querySelector('i').classList.remove('bi-check-lg')
                td[5].querySelector('button').classList.add('btn-danger')
                td[5].querySelector('button').classList.remove('btn-success')
            })
            $.ajax({
                url: '/belanja/rencana/get',
                method: 'POST',
                data: {
                    group: Number(group)
                },
                success: (res) => {
                    document.querySelector('#detail-loading').style.display = 'none'
                    currentGroup = res.value
                    // console.log(res)
                    const keys = Object.keys(item)
                    var table = document.querySelector('#detail-item-container').querySelector('tbody')
                        .querySelectorAll('tr')
                    table.forEach(function(row, index) {
                        var code = row.querySelector('td').innerText;
                        var td = row.querySelectorAll('td');

                        // Assuming `group` and `res` are defined outside this loop
                        if (group === Number(td[7].innerText)) {
                            var options = {
                                style: 'decimal',
                                maximumFractionDigits: 2
                            };
                            var formattedNumber = (res.value[index].qty * res.value[index].harga_awal)
                                .toLocaleString('en-US', options);


                            row.style.display = 'table-row';
                            td[3].innerText = res.value[index].qty;
                            td[4].querySelector('span').innerText = 'Rp ' + formattedNumber;
                            parseFloat(formattedNumber.replace(/,/g, ''));
                            if (res.value[index].checked === 1) {
                                td[5].querySelector('button').querySelector('i').classList.remove(
                                    'bi-square')
                                td[5].querySelector('button').querySelector('i').classList.add(
                                    'bi-check-lg')
                                td[5].querySelector('button').classList.remove('btn-danger')
                                td[5].querySelector('button').classList.add('btn-success')
                            }
                        }
                    });
                },
                error: (err) => {
                    console.error(err);
                }
            })
        }

        function submitRencana(button) {
            var uncle = button.parentNode.parentNode.querySelectorAll('td');
            button.querySelector('span').classList.remove('visually-hidden');
            button.disabled = true;

            $.ajax({
                url: '/belanja/submit-rencana',
                method: 'POST',
                data: {
                    kode: Number(uncle[0].innerText)
                },
                success: (res) => {
                    console.log(res)
                    if (res.status) {
                        button.querySelector('span').classList.add('visually-hidden');
                        button.classList.add('btn-success')
                        button.classList.remove('btn-warning')
                    }
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
