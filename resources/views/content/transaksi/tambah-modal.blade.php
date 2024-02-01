<div class="modal fade shadow" id="tambah-modal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen shadow">
        <div class="modal-content shadow" style="background-color: rgb(235, 235, 235)">
            <div class="modal-header">
                <h5 style="display: flex; align-items: center; gap: 10px;" class="modal-title"><i
                        class="bi bi-info-circle"></i>
                    Catat Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="width: 100%; display: flex; justify-content: center;align-items:center">
                <div class="row g-3" style="display: flex; width: 100%;">
                    <div>
                        <div class="search-bar" style='display: flex; width: 100%; margin-bottom: 10px;'>
                            <div class="search-form d-flex align-items-center" style='width: 100%'>
                                <input style='width: 100%; padding: 5px;' type="text" name="query"
                                    placeholder="Cari nama, kode, atau kategori" id='search-item' title="Cari Barang"
                                    oninput="searchBar(value)">
                            </div>
                        </div>
                        <div id='items-in' class="card" style="border: 1px solid darkgray">
                            <div class="card-body overflow-auto" style="max-height: 300px">
                                <table id='item-container' class="table table-borderless table-hover"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Stok</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody style="width: 100%">
                                        @foreach ($items as $item)
                                            <tr onclick="chooseItem({{ $item }})" style="width: 100;"
                                                id='item{{ $item->kode }}'>
                                                <td style='max-width: 100px; align-items: center'>
                                                    {{ $item->kode }}</td>
                                                {{-- <td>
                                                    <img src="{{ $item->foto }}" width="30"
                                                        alt='preview-{{ $item->kode }}' />
                                                </td> --}}
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $cat[$item->kategori] }}</td>
                                                <td>{{ $item->stok }}</td>
                                                <td style='height: 100%'>
                                                    <button style="scale: 0.8; font-weight: 900" type='button'
                                                        title='add-item' class="btn btn-warning shadow"
                                                        onclick="addItem({{ $item->kode }})">
                                                        <i id='icon{{ $item->kode }}' class="bi bi-plus-lg"
                                                            style="font-weight: 900"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <h6 id='item-value-title'>Silahkan Pilih Item</h6>
                        <div class="search-bar" style='display: flex; width: 100%; margin-bottom: 10px;'>
                            <div class="search-form d-flex align-items-center" style='width: 100%'>
                                <input style='width: 100%; padding: 5px;' type="number" name="query"
                                    placeholder="Jumlah Barang" id='count-item' title="Jumlah Barang"
                                    oninput="changeCount(value)">
                            </div>
                        </div>
                    </div>
                    <div id='single-container'>
                        <form id='single-form'>
                            <input onchange="toggleSgl()" style='display: none' value='' type="number"
                                name='kode' id='sgl-kode'>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#konfirmasi-catat">Catat!</button>
                                <button onclick="resetAll()" type="button" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    var cats = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
                    var kodes = [];
                    var currentKode = -1;

                    function resetAll() {
                        kodes.forEach(function(code) {
                            var row = document.querySelector(`#item${code.kode}`);
                            var td = row.querySelectorAll('td');
                            td.forEach(function(el) {
                                el.classList.remove('bg-secondary');
                                el.style.color = 'black';
                            });
                            td[3].querySelector('button').querySelector('i').classList.add('bi-plus-lg')
                            td[3].querySelector('button').querySelector('i').classList.remove('bi-trash')
                        });

                        document.querySelector('#count-item').disabled = true
                        document.querySelector('#count-item').value = 0
                        document.querySelector('#item-value-title').innerHTML = `Silah Pilih Item`;
                        kodes = [];
                    }

                    function changeCount(value) {
                        var indexToUpdate = kodes.findIndex(function(item) {
                            return item.kode === currentKode;
                        });
                        if (indexToUpdate !== -1) {
                            kodes[indexToUpdate].count = Number(value);
                        } else {
                            return;
                        }
                    }

                    function chooseItem(item) {
                        var icon = document.querySelector(`#icon${item.kode}`)
                        if (icon.classList.contains('bi-plus-lg')) {
                            return;
                        }
                        currentKode = item.kode;
                        var indexToUpdate = kodes.findIndex(function(each) {
                            return each.kode === item.kode;
                        });
                        document.querySelector('#count-item').disabled = false
                        document.querySelector('#count-item').value = kodes[indexToUpdate].count
                        document.querySelector('#item-value-title').innerHTML = `
                        Input Jumlah Barang untuk <span class='text-danger'>${item.nama}</span>
                        `;
                    }

                    function submitTransaction() {
                        console.log(kodes)
                        if (kodes.length === 0) {
                            return;
                        }
                        $.ajax({
                            url: '/transaksi/add',
                            type: 'POST',
                            data: {
                                transactionItems: kodes
                            },
                            success: function(res) {
                                if (res.success) {
                                    console.log(res)
                                    window.location.reload();
                                } else {
                                    $('#error-notification').modal('show');
                                    document.querySelector('#error-notification-content').textContent = res.message;
                                    console.log('pesan: ', res.message)
                                }
                            },
                            error: function(error) {
                                console.error(error);
                                // Handle errors here
                            }
                        });
                    }

                    function resetForm(event) {
                        event.preventDefault();
                        var sglForm = document.querySelector('#single-form');
                        var items = document.querySelector('#items-in');

                        sglForm.reset();

                    }

                    function toggleSgl() {
                        console.log('An Item Added');
                    }

                    function addItem(kode) {
                        var base = document.querySelector('#sgl-kode')
                        var items = document.querySelector('#items-in')
                        base.value = kode;
                        var row = document.querySelector(`#item${kode}`)
                        var td = row.querySelectorAll('td');
                        td.forEach(function(el) {
                            if (el.classList.contains('bg-secondary')) {
                                el.classList.remove('bg-secondary')
                                el.style.color = 'black';
                            } else {
                                el.style.color = 'white';
                                el.classList.add('bg-secondary')
                            }
                        })

                        var icon = document.querySelector(`#icon${kode}`)
                        if (icon.classList.contains('bi-plus-lg')) {
                            icon.classList.remove('bi-plus-lg')
                            icon.classList.add('bi-trash')

                            var newItem = {
                                kode: kode,
                                count: 0
                            }
                            kodes = [...kodes, newItem]

                        } else {
                            currentKode = -1
                            document.querySelector('#count-item').value = 0;
                            document.querySelector('#item-value-title').textContent = `Silahkan Pilih Item`
                            icon.classList.add('bi-plus-lg')
                            icon.classList.remove('bi-trash')

                            kodes = kodes.filter(function(item) {
                                return item.kode !== kode;
                            });
                        }
                    }

                    function searchBar(value) {
                        var searchValue = value.toLowerCase();
                        var rows = document.querySelectorAll('#item-container tbody tr');

                        rows.forEach(function(row) {
                            var kode = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
                            var nama = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
                            var kategori = row.querySelector('td:nth-child(3)').innerText.toLowerCase();

                            if (kode.includes(searchValue) || nama.includes(searchValue) || kategori.includes(searchValue)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    }
                </script>
            </div>
        </div>
    </div>
</div>
<div class="modal fade shadow" id="konfirmasi-catat" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content p-3 ">
            <div class="modal-body text-center">
                Konfirmasi catat transaksi
            </div>
            <div class="text-center" style="gap: 10px;">
                <button type="button" style="margin-right: 10px;" class="btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#tambah-modal">Batal
                </button>
                <button type='button' onclick="submitTransaction()" style="margin-left: 10px;"
                    class="btn btn-primary">Catat
                </button>`
            </div>
        </div>
    </div>
    <script></script>
</div>

@include('content.error-notif')
