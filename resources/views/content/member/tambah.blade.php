@if (Auth::check())
    @if (Auth::user()->role != 'super')
        <script>
            window.location.href = '/'
        </script>
    @endif
@else
    <script>
        window.location.href = '/session'
    </script>
@endif

@extends('layout.index')
@section('title')
    Tambah Member - PlinPlan
@endsection
@section('body')
    <script>
        document.querySelector('#components-nav').classList.remove('collapse');
        document.querySelector('#components-nav').classList.add('show');
        document.querySelector('#member').classList.remove('collapsed');
    </script>
    <section class="section">

        <div class="card">
            <div class="card-body overflow-auto">
                <div class="card-title">
                    <nav class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('member') }}">Member</a></li>
                            <li class="breadcrumb-item active">Tambah Member</li>
                        </ol>
                    </nav>
                    Tambah Member
                    <div class="text-muted small" style="font-size:;">
                    </div>
                </div>
                <div class="container">

                    <section class="section d-flex flex-column align-items-center justify-content-center pb-4">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">

                                    <div class="pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Buat Akun Member</h5>
                                    </div>

                                    <form action="{{ route('create-member') }}" id='register-form'
                                        class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        {{ csrf_field() }}
                                        <div class="col-12 align-items-center d-flex flex-column">
                                            <img id='preview-brg' src='/assets/img/users/user_default.png' width='200'
                                                class="profile-container-small">
                                            <div class="" id='error-file-type' style='display: none;'>
                                                <h3 class="btn badge bg-danger">Format file tidak didukung</h3>
                                            </div>
                                            <div style="display: flex; gap: 10px;" class="mt-2">
                                                <label class="btn btn-primary btn-sm" for='file'><i
                                                        class="bi bi-box-arrow-up"></i>Upload</label>
                                                <input onchange="checkState(event)" style="display: none" type="file"
                                                    name='file' id="file" onchange="changeUpdateVisibility()"
                                                    class="btn btn-primary btn-sm" title="Upload new profile image">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" placeholder="Masukkan nama..." name="name"
                                                class="form-control" id="name"
                                                value="{{ Session::get('nama-member') }}" required>
                                            <div class="invalid-feedback">Tolong isi field Nama!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <input placeholder="Masukkan email..." type="email" name="email"
                                                class="form-control" id="email"
                                                value="{{ Session::get('email-member') }}" required>
                                            <div class="invalid-feedback">Isi email dengan benar!</div>
                                        </div>

                                        <div class="col-12">
                                            @php
                                                $cat = ['super', 'normal'];
                                            @endphp
                                            <button id='choose-category' type='button'
                                                class=" btn btn-outline-secondary d-flex align-items-center"
                                                data-bs-toggle="dropdown">

                                                <i class="d-md-none d-block bi bi-funnel-fill"></i>
                                                <span id='category-title' class="dropdown-toggle">
                                                    Role
                                                </span>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-start" id='category-list'>
                                                @for ($i = 0; $i < 2; $i++)
                                                    <li class="">
                                                        <button type='button'
                                                            class="dropdown-item d-flex align-items-center"
                                                            onclick="changeCategoryItem({{ $i }})">
                                                            <i class="bi bi-caret-right-fill"></i>
                                                            <span
                                                                style='display: flex; justify-content: space-between; width: 100%'>
                                                                {{ $cat[$i] }}
                                                            </span>
                                                        </button>
                                                    </li>
                                                @endfor

                                            </ul>
                                            <input style="display: none;" value='normal' required name='role_member'
                                                type="text" class="form-control" id="role-member">
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <input placeholder="Password..." type="password" name="password"
                                                    class="form-control" id="password" required>
                                                <i onclick='changeVisibility("password")'
                                                    class="btn input-group-text bi bi-eye" id="inputGroupPrepend"></i>
                                                <div class="invalid-feedback">Tolong isi password dengan benar!
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="confirmationPassword" class="form-label">Konfirmasi
                                                Password</label>
                                            <div class="input-group has-validation">
                                                <input placeholder="Konfirmasi password..." type="password"
                                                    name="confirmationPassword" class="form-control"
                                                    id="confirmationPassword" required>
                                                <i onclick='changeVisibility("confirmationPassword")'
                                                    class="btn input-group-text bi bi-eye" id="inputGroupPrepend"></i>
                                                <div class="invalid-feedback">Tolong isi password dengan benar!
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12" id='loading-notification' style='display: none;'>
                                            <h3 class="btn w-100 badge bg-primary">Sedang memproses</h3>
                                        </div>
                                        <div class="col-12" id='error-notification' style='display: none;'>
                                            <h3 id='error-text' class="btn w-100 badge bg-danger">Password tidak
                                                vaild
                                            </h3>
                                        </div>
                                        {{-- <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="terms" type="checkbox"
                                                            value="" id="acceptTerms" required>
                                                        <label class="form-check-label" for="acceptTerms">I agree and accept the
                                                            <a href="#">terms and conditions</a></label>
                                                        <div class="invalid-feedback">You must agree before submitting.</div>
                                                    </div>
                                                </div> --}}
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 mb-2" type="submit">Buat
                                                Akun</button>
                                            <button class="btn btn-danger w-100" type="reset">Reset</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </section>

                </div>
                </main>
            </div>
        </div>
    </section>
    <div class="modal fade shadow show" id="tambah-modal" tabindex="-1" data-bs-backdrop="true">
        <div class="modal-dialog modal-dialog-centered show">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="display: flex; align-items: center; gap: 10px;" class="modal-title">
                        <i class="badge bg-danger">
                            <i class="bi bi-shield-slash"></i>
                        </i>
                        Galat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="width: 100%; display: flex; justify-content: center;align-items:center">
                    @if ($errors->has('error'))
                        {{ $errors->first('error') }}
                    @endif
                </div>
                <div class="modal-footer" style="width: 100%; display: flex; justify-content: center;align-items:center">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showErrors() {
            $(document).ready(function() {
                // Show the modal with the specified ID
                $('#tambah-modal').modal('show');
            });
        }

        console.log('{{ $errors }}')

        @if ($errors->has('error'))
            console.log('true');
            showErrors();
        @endif
        var cats = ['super', 'normal']

        function checkState(event) {
            if (handleFileSelect(event)) {
                document.querySelector('#error-file-type').style.display = 'block'
            } else {
                document.querySelector('#error-file-type').style.display = 'none'
                previewBarang('file', 'preview-brg')
            }
        }

        function changeCategoryItem(cat) {
            document.querySelector('#choose-category').innerHTML = `
                        <i class="d-md-none d-block bi bi-funnel-fill"></i>
                                            <span class="d-none d-md-block dropdown-toggle">
                                                ${cats[cat]}
                                            </span>`;
            document.querySelector('#role-member').value = cats[cat];
            console.log(document.querySelector('#role-member').value)
            // document.querySelector('#category-title').innerHTML = cats[cat];
        }

        function changeVisibility(ids) {
            const field = document.querySelector(`#${ids}`);
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }
    </script>

    @include('content.items.preview-script')
    @include('content.filter-file')
@endsection
