<div class="modal fade shadow " id="tambah-modal" tabindex="-1" data-bs-backdrop="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="display: flex; align-items: center; gap: 10px;" class="modal-title"><i
                        class="bi bi-info-circle"></i>
                    Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="width: 100%; display: flex; justify-content: center;align-items:center">
                <form class="row g-3" style="display: flex; width: 100%;" method="post" action='{{ route('create') }}'
                    enctype="multipart/form-data">
                    @csrf
                    {{ csrf_field() }}
                    <div class="d-block d-md-flex" style="gap: 20px; width: 100%;">
                        <div>
                            <img id='preview-brg' src='/assets/img/product-3.jpg' width='200'
                                class="profile-container-small">
                            <div class="" id='error-file-type' style='display: none;'>
                                <h3 class="btn badge bg-danger">Format file tidak didukung</h3>
                            </div>
                            <div style="display: flex; gap: 10px;" class="mt-2">
                                <label class="btn btn-primary btn-sm" for='file'><i
                                        class="bi bi-box-arrow-up"></i>Upload</label>
                                <input onchange="checkState(event)" style="display: none" type="file" name='file'
                                    id="file" onchange="changeUpdateVisibility()" class="btn btn-primary btn-sm"
                                    title="Upload new profile image">
                            </div>
                        </div>
                        <div style="display: block; width: 100%;">
                            <div class="col-12">
                                <label class="form-label">Nama Barang</label>
                                <input required name='nama_brg' type="text" class="form-control" id="nama-brg">
                            </div>
                            <div class="my-3 " style="width: 200px;">

                                <?php
                                $cat = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
                                ?>
                                <button id='choose-category' type='button'
                                    class=" btn btn-outline-secondary d-flex align-items-center"
                                    data-bs-toggle="dropdown">

                                    <i class="d-md-none d-block bi bi-funnel-fill"></i>
                                    <span class=dropdown-toggle">
                                        Kategori
                                    </span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-start" id='category-list'>
                                    @for ($i = 0; $i < 4; $i++)
                                        <li class="">
                                            <button type='button' class="dropdown-item d-flex align-items-center"
                                                onclick="changeCategory({{ $i }})">
                                                <i class="bi bi-caret-right-fill"></i>
                                                <span
                                                    style='display: flex; justify-content: space-between; width: 100%'>
                                                    {{ $cat[$i] }}
                                                </span>
                                            </button>
                                        </li>
                                    @endfor

                                </ul>
                                <input style="display: none;" value='3' required name='kategori_brg' type="number"
                                    class="form-control" id="kategori-brg">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Stok</label>
                                <input required name='stok_brg' type="number" class="form-control" id="stok-brg">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Harga Awal</label>
                                <input required name='hrg_awl_brg' type="number" class="form-control"
                                    id="hrg-awl-brg"">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Harga Jual</label>
                                <input required name='hrg_jual_brg' type="number" class="form-control"
                                    id="hrg-jual-brg"">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name='desk_brg' type="text" class="form-control" id="desk-brg""></textarea>
                            </div>
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Kembali</button>
                            </div>
                        </div>
                    </div>
                </form>
                <script>
                    var cats = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];

                    function checkState(event) {
                        if (handleFileSelect(event)) {
                            document.querySelector('#error-file-type').style.display = 'block'
                        } else {
                            document.querySelector('#error-file-type').style.display = 'none'
                            previewBarang('file', 'preview-brg')
                        }
                    }

                    function changeCategory(cat) {
                        document.querySelector('#choose-category').innerHTML = `
                        <i class="d-md-none d-block bi bi-funnel-fill"></i>
                                            <span class="d-none d-md-block dropdown-toggle">
                                                ${cats[cat]}
                                            </span>`;
                        document.querySelector('#kategori-brg').value = cat;
                        console.log(document.querySelector('#kategori-brg').value)
                    }
                </script>
                @include('content.items.preview-script')
                @include('content.filter-file')
            </div>
        </div>
    </div>
</div>
