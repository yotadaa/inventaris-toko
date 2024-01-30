@extends('layout.index')

@section('title')
    Tambah Item
@endsection
@section('misc')
    <style>
        input[type='file'] {
            display: none
        }

        .input-file {
            display: inline-block;
            padding: 8px 12px;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
@endsection
@section('body')
    <?php
    $cats = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
    ?>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    Edit Barang
                    <nav class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('items') }}">Barang</a></li>
                            <li class="breadcrumb-item active">Edit Barang</li>
                        </ol>
                    </nav>
                </div>
                <form class="row g-3" style="display: flex" method="post" action='{{ route('update') }}'
                    enctype="multipart/form-data">
                    @csrf
                    {{ csrf_field() }}
                    <input style="display: none" value='{{ $item->kode }}' name='kode' type='number'>
                    <input style="display: none" value='{{ $item->email }}' name='email' type='email'>
                    <input style="display: none" value='{{ $item->foto }}' name='foto' type='text'>
                    <div class="d-block d-md-flex" style="gap: 20px; width: 100%;">
                        <div class="mb-4">
                            <img id='preview-brg' src='../{{ $item->foto }}' width='200'
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
                                <input value='{{ $item->nama }}' required name='nama_brg' type="text"
                                    class="form-control" id="nama-brg">
                            </div>
                            <div class="my-3 " style="width: 200px;">

                                <?php
                                $cat = ['Makanan', 'Minuman', 'Rokok', 'Lainnya'];
                                ?>
                                <button id='choose-category' type='button'
                                    class=" btn btn-outline-secondary d-flex align-items-center" data-bs-toggle="dropdown">

                                    <i class="d-md-none d-block bi bi-funnel-fill"></i>
                                    <span class="d-none d-md-block dropdown-toggle">
                                        {{ $cat[$item->kategori] }}
                                    </span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-start" id='category-list'>
                                    @for ($i = 0; $i < 4; $i++)
                                        <li class="">
                                            <button type='button' class="dropdown-item d-flex align-items-center"
                                                onclick="changeCategory({{ $i }})">
                                                <i class="bi bi-caret-right-fill"></i>
                                                <span style='display: flex; justify-content: space-between; width: 100%'>
                                                    {{ $cat[$i] }}
                                                </span>
                                            </button>
                                        </li>
                                    @endfor

                                </ul>
                                <input style="display: none;" value='{{ $item->kategori }}' required name='kategori_brg'
                                    type="number" class="form-control" id="kategori-brg">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Stok</label>
                                <input value='{{ $item->stok }}' required name='stok_brg' type="number"
                                    class="form-control" id="stok-brg">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Harga Awal</label>
                                <input value='{{ $item->harga_awal }}' required name='hrg_awl_brg' type="number"
                                    class="form-control" id="hrg-awl-brg"">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Harga Jual</label>
                                <input value='{{ $item->harga_jual }}'' required name='hrg_jual_brg' type="number"
                                    class="form-control" id="hrg-jual-brg"">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name='desk_brg' type="text" class="form-control" id="desk-brg">{{ $item->desk }}</textarea>
                            </div>
                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
    </section>
@endsection
