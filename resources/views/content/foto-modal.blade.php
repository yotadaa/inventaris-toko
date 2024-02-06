<div class="modal fade " id="foto-modal" tabindex="-1" data-bs-backdrop="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content " style="background-color: rgb(235, 235, 235)">
            <div class="modal-body" style="width: 100%; display: flex; justify-content: center;align-items:center">
                @if ($user)
                    <img src={{ asset($user->foto_profile) }} width='100%' style='width: 100%, height: 100%' />
                @endif
            </div>
        </div>
    </div>
</div>
