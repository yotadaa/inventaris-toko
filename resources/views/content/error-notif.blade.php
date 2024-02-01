<div class="modal fade" id="error-notification" tabindex="-1" data-bs-backdrop="true">
    <div class="modal-dialog modal-dialog-centered modal-small">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h5 style="display: flex; align-items: center; gap: 10px;" class="modal-title"><i
                        class="bi bi-info-circle"></i>
                    Error!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="width: 100%; display: flex; justify-content: center;align-items:center">
                <div id='error-notification-content'></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambah-modal"
                    onclick="goBack()">Kembali</button>

            </div>
        </div>
    </div>
    <script>
        function goBack() {
            $(`#error-notification`).modal('hide');
        }
    </script>
</div>
