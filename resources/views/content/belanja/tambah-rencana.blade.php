<script>
    var rencanaItem = [];
    var isSubmitting = false;
</script>
<div class="modal fade shadow" id="tambah-rencana" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen shadow">
        <div class="modal-content shadow" style="">
            <div class="modal-header">
                <h5 style="display: flex; align-items: center; gap: 10px;" class="modal-title"><i
                        class="bi bi-info-circle"></i>
                    Rencana Belanja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="width: 100%; ">
                <div class="">

                    <div>
                        <div class="search-bar" style='display: flex; width: 100%; margin-bottom: 10px;'>
                            <div class="search-form d-flex align-items-center" style='width: 100%'>
                                <input style='width: 100%; padding: 5px;' type="text" name="query"
                                    placeholder="Cari nama, kode, atau kategori" id='search-item-rencana'
                                    title="Cari Barang" oninput="searchBar(value)">
                            </div>
                        </div>
                    </div>
                    <div class="small text-danger">**Klik tombol dua kali</div>
                    <table id='item-container' class="table table-borderless table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle">Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody style="width: 100%">
                            @foreach ($items as $item)
                                <tr style="width: 100;" id='item{{ $item->kode }}'>
                                    <td class="text-center"
                                        style='max-width: 100px; align-items: center; vertical-align: middle'>
                                        {{ $item->kode }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $cat[$item->kategori] }}</td>
                                    <td style='max-width: 100px'>
                                        <input min='0' disabled='true' oninput="changeItemValue(this)"
                                            style='width: 100px; padding: 5px;border-radius: 5px;outline: none;border-width: 1px;'
                                            type="number" name="value{{ $item->kode }}" placeholder="Jumlah"
                                            id='value{{ $item->kode }}' title="Cari Barang" </td>
                                    <td style='height: 100%;justify-content: start;' class='d-flex'>
                                        <button style="scale: 0.8; font-weight: 900" type='button' title='add-item'
                                            class="btn btn-warning shadow" ondblclick="checkItem(this)">
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
            <div class="modal-footer">
                <button type="button" onclick="tambahRencana()" class="btn btn-primary" data-bs-dismiss="modal">Tambah
                    Rencana</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function tambahRencana() {
        if (isSubmitting) {
            return;
        }
        isSubmitting = true;
        $.ajax({
            url: '/belanja/add-rencana',
            method: 'POST',
            data: {
                rencanaItem: rencanaItem
            },
            success: (res) => {
                if (res.success) {
                    isSubmitting = false;
                    window.location.reload();
                } else {
                    console.log(res)
                }
            },
            error: (err) => {
                console.error(err)
            }
        })
    }

    function changeItemValue(input) {
        var uncle = input.parentNode.parentNode.querySelectorAll('td')
        var index = rencanaItem.findIndex(function(item) {
            return item.kode === Number(uncle[0].innerText);
        });
        rencanaItem[index].qty = Number(input.value);
    }

    function searchBar(value) {
        var searchValue = value.toLowerCase();
        var rows = document.querySelectorAll('#item-container tbody tr');

        rows.forEach(function(row) {
            var kode = row.querySelector('td:nth-child(1)').innerText.toLowerCase();
            var nama = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
            var kategori = row.querySelector('td:nth-child(3)').innerText.toLowerCase();

            if (kode.includes(searchValue) || nama.includes(searchValue) || kategori.includes(
                    searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function checkItem(button) {
        var itemValue = button.parentNode.parentNode.querySelectorAll('td')[3].querySelector('input')
        var uncle = button.parentNode.parentNode.querySelectorAll('td')
        var icon = button.querySelector('i')

        if (icon.classList.contains('bi-plus-lg')) {
            icon.classList.remove('bi-plus-lg');
            icon.classList.add('bi-check-lg')
            button.classList.remove('btn-warning')
            button.classList.add('btn-success')
            itemValue.disabled = false
            uncle.forEach(function(el) {
                el.style.backgroundColor = '#B7E5B4'
            })
            rencanaItem = [...rencanaItem, {
                kode: Number(uncle[0].innerText),
                qty: 0
            }]

        } else {
            itemValue.disabled = true
            itemValue.value = '';
            icon.classList.add('bi-plus-lg');
            icon.classList.remove('bi-check-lg')
            button.classList.remove('btn-success')
            button.classList.add('btn-warning')
            uncle.forEach(function(el) {
                el.style.backgroundColor = 'white'
            })

            var index = rencanaItem.findIndex(function(item) {
                return item.kode === Number(uncle[0].innerText);
            });
            if (index != -1) {
                rencanaItem.splice(index, 1)
            }
        }
        console.log(rencanaItem)
    }
</script>
