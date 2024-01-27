<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" id='dashboard' href="{{ route('index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="components-alerts.html">
                        <i class="bi bi-circle"></i><span>Daftar Item</span>
                    </a>
                </li>
                <li>
                    <a href="components-alerts.html">
                        <i class="bi bi-circle"></i><span>Catat Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="components-alerts.html">
                        <i class="bi bi-circle"></i><span>Catat Perbelanjaan</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" id='analisis' href="{{ route('user') }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>Analisis</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" id='user' href="{{ route('user') }}">
                <i class="bi bi-person"></i>
                <span>User</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" id='logout' href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-left
                "></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->
