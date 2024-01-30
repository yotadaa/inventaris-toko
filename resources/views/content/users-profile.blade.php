@extends('layout.index')
@section('title')
    Profile User
@endsection

@section('misc')
    @include('no-reload.head')
@endsection
@section('body')
    @include('no-reload.body-up')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Change Password</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-edit" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form method="post" action=" {{ route('update-photo') }}" id='user-form'
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3 col-form-label">Profile
                                            Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            @if ($user)
                                                <img id='setting-profile' src="{{ $user->foto_profile }}" alt="Profile">
                                            @endif
                                            <div class="" id='error-file-type' style='display: none;'>
                                                <h3 class="btn badge bg-danger">Format file tidak didukung</h3>
                                            </div>

                                            <div class="pt-2" style="display: flex; align-items: center; gap: 5px;">
                                                <input type="file" name='file' id="file"
                                                    onchange="changeUpdateVisibility(event)" class="btn btn-primary btn-sm"
                                                    title="Upload new profile image">
                                                {{-- <input type="file" name="file"> --}}
                                                <button type='button' data-bs-toggle="modal"
                                                    data-bs-target="#deletePhotoConfirmation" href="#"
                                                    class="btn btn-danger btn-sm" title="Remove my profile image"><i
                                                        class="bi bi-trash"></i>
                                                </button>
                                                <button type='submit' value='' href="#"
                                                    class="btn btn-success btn-sm" id='updateButton' style='display: none'
                                                    title="Update">
                                                    <i class="bi bi-box-arrow-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @if ($user)
                                    <form>
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full
                                                Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="fullName" type="text" class="form-control" id="fullName"
                                                    value="{{ $user->name }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input disabled='true' class="form-control" id="Email"
                                                    value="{{ $user->email }}">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="button" onclick="submitForm()" class="btn btn-primary">Save
                                                Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->
                                @endif

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form id='change-password-form'>
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control"
                                                id="currentPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control" id="newPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter
                                            New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renewpassword" type="password" class="form-control"
                                                id="renewPassword">
                                        </div>
                                    </div>

                                    <div class="col-12" id='loading-notification' style='display: none;'>
                                        <h3 class="btn w-100 badge bg-primary">Sedang memproses</h3>
                                    </div>

                                    <div class="col-12" id='error-notification' style='display: none;'>
                                        <h3 id='error-text' class="btn w-100 badge bg-danger"></h3>
                                    </div>

                                    <div class="text-center">
                                        <button onclick="changePassword()" type="button" class="btn btn-primary">Change
                                            Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
    @include('content.filter-file')
    <div class="modal fade" id="deletePhotoConfirmation" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-body text-center">
                    Konfirmasi menghapus foto profile?
                </div>
                <div class="text-center" style="gap: 10px;">
                    <button type="button" style="margin-right: 10px;" class="btn btn-secondary"
                        data-bs-dismiss="modal">Batal
                    </button>
                    <button type='button' onclick="deleteConfirmed()" style="margin-left: 10px;"
                        class="btn btn-primary">Konfir
                    </button>`
                </div>
            </div>
        </div>
        <script>
            function deleteConfirmed() {
                window.location.href = "{{ route('delete-photo') }}";
            }
        </script>
    </div>
    <script>
        function changeUpdateVisibility(event) {
            var updateButton = document.querySelector('#updateButton');
            document.querySelector('#error-file-type').style.display = 'none'
            if (handleFileSelect(event)) {
                document.getElementById('file').value = ''
                updateButton.style.display = 'none';
                document.querySelector('#error-file-type').style.display = 'block'
            } else {
                previewBarang('file', 'setting-profile')
                document.querySelector('#error-file-type').style.display = 'none'
                updateButton.style.display = 'flex';
                updateButton.style.width = '33px';
            }
            // console.log(updateButton.style.display)
        }

        function submitForm() {
            // document.querySelector('#test').value = document.querySelector('#file').value
            $.ajax({
                url: '/upload-files',
                type: 'POST',
                data: $('#user-form').serialize(),
                success: function(res) {
                    console.log(res);
                },
                error: function(error) {
                    console.error(error);
                    // Handle errors here
                }
            });
        }

        function changePassword() {
            document.querySelector('#loading-notification').style.display = 'block'
            document.querySelector('#error-notification').style.display = 'none'
            $.ajax({
                url: '/change-password',
                type: 'POST',
                data: $('#change-password-form').serialize(),
                success: function(res) {
                    if (!res.status) {
                        document.querySelector('#loading-notification').style.display = 'none'
                        document.querySelector('#error-notification').style.display = 'block'
                        document.querySelector('#error-text').textContent = res.message
                    }
                },
                error: function(err) {
                    console.error(err)
                }
            })
        }
    </script>
    @include('content.items.preview-script')
    <script>
        var current = document.querySelector("#user");
        current.classList.remove('collapsed');
    </script>
@endsection
