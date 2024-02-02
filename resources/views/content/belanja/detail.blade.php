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

                    <div class="d-block" style="width: 100%;flex-direction: row; gap: 10px;">
                        <div style="width: 100%">
                            <div class="col-12">
                                <label class="form-label">Waktu</label>
                                <input disabled='true' type="text" class="form-control" id="waktu-brg">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nama Barang</label>
                                <input disabled='true' type="text" class="form-control" id="nama-brg">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Kategori</label>
                                <input disabled='true' type="text" class="form-control" id="kategori-brg">
                            </div>
                        </div>
                        <div style="width: 100%">
                            <div class="col-12">
                                <label class="form-label">Terjual</label>
                                <input disabled='true' type="number" class="form-control" id="keluar-brg"
                                    placeholder="1234 Main St">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Pendapatan</label>
                                <input disabled='true' type="text" class="form-control" id="pendapatan-brg"
                                    placeholder="1234 Main St">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="display: flex; justify-content: start; align-items: center">
                <button type="button" class="btn btn-warning"><i class="bi bi-pencil-square"></i>Edit</button>
                <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i>Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
