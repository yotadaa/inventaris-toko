<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Daftar - PlinPlan</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 09 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    @if (Auth::check())
        <script>
            window.location.href = '/'
        </script>
    @endif

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{ route('index') }}" class="logo d-flex align-items-center w-auto">
                                    <span class="d-none d-lg-block">PlinPlan</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3" style='width: 500px;'>

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Buat Akun</h5>
                                        <p class="text-center small">Mohon isi form berikut untuk membuat akun</p>
                                    </div>

                                    <form id='register-form' class="row g-3 needs-validation" novalidate>
                                        <div class="col-12">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" placeholder="Masukkan nama..." name="name"
                                                class="form-control" id="name" value="{{ Session::get('nama') }}"
                                                required>
                                            <div class="invalid-feedback">Tolong isi field Nama!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <input placeholder="Masukkan email..." type="email" name="email"
                                                class="form-control" id="email" value="{{ Session::get('email') }}"
                                                required>
                                            <div class="invalid-feedback">Isi email dengan benar!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <input placeholder="Password..." type="password" name="password"
                                                    class="form-control" id="password" required>
                                                <i onclick='changeVisibility("password")'
                                                    class="btn input-group-text bi bi-eye" id="inputGroupPrepend"></i>
                                                <div class="invalid-feedback">Tolong isi password dengan benar!</div>
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
                                                <div class="invalid-feedback">Tolong isi password dengan benar!</div>
                                            </div>
                                        </div>

                                        <div class="col-12" id='loading-notification' style='display: none;'>
                                            <h3 class="btn w-100 badge bg-primary">Sedang memproses</h3>
                                        </div>
                                        <div class="col-12" id='error-notification' style='display: none;'>
                                            <h3 id='error-text' class="btn w-100 badge bg-danger">Password tidak vaild
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
                                            <button class="btn btn-primary w-100" type="button"
                                                onclick="submitForm()">Buat Akun</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Sudah punya akun? <a href="{{ route('login') }}">Log
                                                    in</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script>
        function submitForm() {

            document.querySelector('#loading-notification').style.display = 'block'
            var password = document.querySelector('#password');
            var confirmationPassword = document.querySelector('#confirmationPassword');
            if (confirmationPassword.value !== password.value) {
                document.querySelector('#loading-notification').style.display = 'none';
                document.querySelector('#error-notification').style.display = 'block';
                document.querySelector('#error-text').textContent = 'Password Tidak Valid';
                return;
            }
            document.querySelector('#error-notification').style.display = 'none';
            $.ajax({
                url: '/session/create',
                type: 'POST',
                data: $('#register-form').serialize(),
                success: function(res) {
                    console.log(res)
                    if (!res.status) {
                        document.querySelector('#error-text').textContent = res.msg;
                        document.querySelector('#loading-notification').style.display = 'none';
                        document.querySelector('#error-notification').style.display = 'block';
                    } else {
                        window.location.href = '/session';
                    }
                },
                error: function(error) {
                    console.error(error);
                    // Handle errors here
                }
            });
        }
    </script>

    <script>
        function changeVisibility(ids) {
            const field = document.querySelector(`#${ids}`);
            if (field.type === 'password') {
                field.type = 'text';
            } else {
                field.type = 'password';
            }
        }
    </script>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
