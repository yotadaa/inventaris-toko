@extends('layout.index')

@section('title')
    Dashboard
@endsection

@section('misc')
@endsection

@section('body')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card shadow">
                            <div class="card-body">
                                <h5 class="card-title">Transaksi Hari Ini</h5>

                                <div class="d-flex align-items-center">
                                    <button type="button" style="border: none;"
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lakukan Transaksi">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                    <div class="ps-3" style='justify-content: start;'>
                                        @if ($transactions->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->count() == 0)
                                            <div style="font-size: 18px; font-weight: 600">Belum ada transaksi</div>
                                        @else
                                            <div class="card-title" style="margin: 0; padding: 0">
                                                {{ $transactions->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->sum('qty') }}
                                                Terjual
                                            </div>
                                        @endif

                                        {{-- <span style="display: flex; align-items: center; gap: 5px;" type="button"
                                            class="btn-primary">
                                            <strong><i class="bi bi-box-arrow-in-down"></i></strong>
                                            Tambah
                                        </span> --}}
                                        <span class="text-muted small pt-2 ps-1">
                                            @if (
                                                $transactions->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->sortByDesc(function ($transaction) {
                                                        return \Carbon\Carbon::parse($transaction->created_at);
                                                    })->first())
                                                {{ $transactions->where('created_at', '>=', now()->startOfDay())->where('created_at', '<=', now()->endOfDay())->sortByDesc(function ($transaction) {
                                                        return \Carbon\Carbon::parse($transaction->created_at);
                                                    })->first()->qty }}
                                                Item transaksi terakhir
                                            @else
                                                Belum ada transaksi
                                            @endif
                                        </span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card shadow">

                            <div class="card-body">
                                <h5 class="card-title">Pendapatan Hari Ini</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <div class="card-title" style="margin: 0; padding: 0">
                                            @php
                                                $todaySum = 0;
                                                foreach ($transactions as $item) {
                                                    if (\Carbon\Carbon::parse($item->created_at)->isToday()) {
                                                        $todaySum += $item->qty * $item->harga_jual;
                                                    }
                                                }
                                            @endphp
                                            RP {{ number_format($todaySum) }}
                                        </div>
                                        <span class="text-success small pt-1 fw-bold">
                                            @php
                                                $pendapatanBersih = 0;
                                                foreach ($transactions as $item) {
                                                    if (\Carbon\Carbon::parse($item->created_at)->isToday()) {
                                                        $pendapatanBersih += $item->qty * $item->harga_jual - $item->qty * $item->harga_awal;
                                                    }
                                                }
                                            @endphp

                                            Rp {{ number_format($pendapatanBersih) }} Bersih
                                        </span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->

                    <!-- Reports -->
                    @include('content.main-component.report')
                    <!-- End Reports -->

                    <!-- Recent Sales -->
                    @include('content.main-component.transaction')
                    <!-- End Recent Sales -->

                    <!-- Top Selling -->
                    @include('content.main-component.popular-item')
                    <!-- End Top Selling -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Belanja Terakhir</h5>

                        <div class="activity">

                            <div class="activity-item d-flex">
                                <div class="activite-label">32 min</div>
                                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                <div class="activity-content">
                                    Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo
                                        officiis</a> beatae
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">56 min</div>
                                <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                <div class="activity-content">
                                    Voluptatem blanditiis blanditiis eveniet
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">2 hrs</div>
                                <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                <div class="activity-content">
                                    Voluptates corrupti molestias voluptatem
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">1 day</div>
                                <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                <div class="activity-content">
                                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati
                                        voluptatem</a> tempore
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">2 days</div>
                                <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                                <div class="activity-content">
                                    Est sit eum reiciendis exercitationem
                                </div>
                            </div><!-- End activity item-->

                            <div class="activity-item d-flex">
                                <div class="activite-label">4 weeks</div>
                                <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                <div class="activity-content">
                                    Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                                </div>
                            </div><!-- End activity item-->

                        </div>

                    </div>
                </div><!-- End Recent Activity -->

            </div><!-- End Right side columns -->

        </div>
    </section>
    <script>
        var current = document.querySelector("#dashboard");
        current.classList.remove('collapsed');
    </script>
@endsection
