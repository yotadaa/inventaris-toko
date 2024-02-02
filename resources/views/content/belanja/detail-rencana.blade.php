<div class="modal fade" id="detail-rencana" tabindex="-1" data-bs-backdrop="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content" style="">
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
                    <table id='detail-item-container' class="table table-borderless table-hover" style="width: 100%">
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
                                <tr style="width: 100; display: none" id='item-detail{{ $item->kode }}'>
                                    <td class="text-center"
                                        style='max-width: 100px; align-items: center; vertical-align: middle'>
                                        {{ $item->kode }}</td>
                                    {{-- <td>
                                                        <img src="{{ $item->foto }}" width="30"
                                                            alt='preview-{{ $item->kode }}' />
                                                    </td> --}}
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $cat[$item->kategori] }}</td>
                                    <td style='max-width: 100px'>
                                        <input min='0' disabled='true' oninput="changeItemValue(this)"
                                            style='width: 100px; padding: 5px;border-radius: 5px;outline: none;border-width: 1px;'
                                            type="number" name="value{{ $item->kode }}" placeholder="Jumlah"
                                            id='value{{ $item->kode }}' title="Cari Barang" </td>
                                    <td style='height: 100%;justify-content: start;' class='d-flex'>
                                        <button style="scale: 0.8; font-weight: 900" type='button' title='add-item'
                                            class="btn btn-danger shadow" onclick="checkDetailItem(this)">
                                            <i id='icon{{ $item->kode }}' class="bi bi-square"
                                                style="font-weight: 900"></i>
                                        </button>
                                    </td>
                                    <td style="display: none">
                                        {{ $item->id }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="resetDetail()" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function resetDetail() {
        var table = document.querySelector('#detail-item-container').querySelector('tbody').querySelectorAll('tr')
        table.forEach(function(row) {
            row.style.display = 'none'
        })
    }
</script>
