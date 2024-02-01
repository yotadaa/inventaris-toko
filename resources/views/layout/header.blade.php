<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('index') }}" class="logo d-flex align-items-center">
            {{-- <img src="/assets/img/logo.png" alt=""> --}}
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                style='margin-right: 5px;'>
                <i class="bi bi-cart"></i>
            </div>
            <span class="d-none d-lg-block">PlinPlan</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <div class="search-bar" style='display: flex;'>
                <form class="search-form d-flex align-items-center" method="POST" action="#">
                    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                </form>
            </div>

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown">

            </li><!-- End Notification Nav -->



            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if ($user)
                        <img id='header_profile' src="{{ asset($user->foto_profile) }}" alt="Profile"
                            class="profile-container-small rounded-circle">
                    @endif
                    {{-- <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-circle" style="scale: 1.7; margin-right: 5px"></i>
                    </div> --}}
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        @if ($user)
                            <span
                                style="display: inline-block; max-width: 130px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                {{ $user->name }}
                            </span>
                        @endif

                    </span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                    <li class="">
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('user') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <button type='button' class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#logoutConfirmation">
                            <i class="bi
                            bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </button>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>
