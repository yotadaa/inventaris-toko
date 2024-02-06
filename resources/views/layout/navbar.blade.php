<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" id='dashboard' href="{{ route('index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a id='kelola-list' class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-menu-button-wide"></i><span>Kelola</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a id='daftar-item' href="{{ route('items') }}">
                        <i class="bi bi-circle"></i><span>Daftar Item</span>
                    </a>
                </li>
                <li>
                    <a id='transaksi' href="{{ route('transaksi') }}">
                        <i class="bi bi-circle"></i><span>Transaksi</span>
                    </a>
                </li>
                <li>
                    <a id='belanja' href="{{ route('belanja') }}">
                        <i class="bi bi-circle"></i><span>Catat Perbelanjaan</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="components-alerts.html">
                        <i class="bi bi-circle"></i><span>Riwayat Transaksi</span>
                    </a>
                </li> --}}
            </ul>
        </li><!-- End Components Nav -->

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" id='analisis' href="{{ route('user') }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>Analisis</span>
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" id='user' href="{{ route('user') }}">
                <i class="bi bi-person"></i>
                <span>User</span>
            </a>
        </li>

        @if ($user && $user->role == 'super')
            <li class="nav-item">
                <a class="nav-link collapsed" id='member' href="{{ route('member') }}">
                    <i class="bi bi-people" style="scale: 1.1"></i>
                    <span>Member</span>
                </a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link collapsed" id='about' href="/about">
                <i class="bi bi-info-circle" style="scale: 1.1"></i>
                <span>About</span>
            </a>
        </li>

        <li class="nav-item">
            <button style="width: 100%" data-bs-toggle="modal" data-bs-target="#logoutConfirmation"
                class="nav-link collapsed" id='logout'">
                <i class="bi bi-box-arrow-left
                "></i>
                <span>Logout</span>
            </button>
        </li>
    </ul>

</aside><!-- End Sidebar-->
<div class="modal fade" id="logoutConfirmation" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-body text-center">
                Konfirmasi log out dari aplikasi?
            </div>
            <div class="text-center" style="gap: 10px;">
                <button type="button" style="margin-right: 10px;" class="btn btn-secondary"
                    data-bs-dismiss="modal">Batal
                </button>
                <button type='button' onclick="logoutConfirmed()" style="margin-left: 10px;"
                    class="btn btn-primary">Konfir
                </button>`
            </div>
        </div>
    </div>
    <script>
        function logoutConfirmed() {
            window.location.href = "{{ route('logout') }}";
        }
    </script>
</div>
