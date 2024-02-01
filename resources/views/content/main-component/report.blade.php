@php
    $report = $transactions->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sortBy('created_at');
    $pendapatan = $report->map(function ($item) {
        return $item->qty * $item->harga_jual;
    });
    $barang = $report->map(function ($item) {
        return $item->qty * $item->harga_jual - $item->qty * $item->harga_awal;
    });

    $lastWeek = now()->startOfWeek();

    $report = $transactions->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sortBy('created_at');

    // Initialize an array with zeros for each day
    $result = [
        'Monday' => 0,
        'Tuesday' => 0,
        'Wednesday' => 0,
        'Thursday' => 0,
        'Friday' => 0,
        'Saturday' => 0,
        'Sunday' => 0,
    ];

    $report
        ->groupBy(function ($transaction) {
            return Carbon\Carbon::parse($transaction->created_at)->dayName;
        })
        ->map(function ($group, $day) use (&$result) {
            $result[$day] = $group->sum('qty');
        });

    $result = array_values($result);

    $report = $transactions->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sortBy('created_at');

    // Initialize an array with zeros for each day
    $weekCount = [
        'Monday' => 0,
        'Tuesday' => 0,
        'Wednesday' => 0,
        'Thursday' => 0,
        'Friday' => 0,
        'Saturday' => 0,
        'Sunday' => 0,
    ];
    $pendapatanValue = $weekCount;
    $barangValue = $weekCount;
    $report
        ->groupBy(function ($transaction) {
            return Carbon\Carbon::parse($transaction->created_at)->dayName;
        })
        ->map(function ($group, $day) use (&$weekCount, &$pendapatanValue, &$barangValue) {
            $weekCount[$day] = $group->count();
            $pendapatanValue[$day] = $group->sum(function ($transaction) {
                return $transaction->qty * $transaction->harga_jual;
            });
            $barangValue[$day] = $group->sum(function ($transaction) {
                return $transaction->qty * $transaction->harga_jual - $transaction->qty * $transaction->harga_awal;
            });
        });

    $weekCount = array_values($weekCount);
    $pendapatanValue = array_values($pendapatanValue);
    $barangValue = array_values($barangValue);

@endphp

<script>
    console.log(@json($barangValue))
    console.log(@json($pendapatanValue))
    console.log('{{ $lastWeek->startOfWeek() }}, {{ $lastWeek->endOfWeek() }}');
    var categories = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
</script>

<div class="col-12">
    <div class="card">

        <div class="card-body">
            <h5 class="card-title">Laporan Pendapatan Minggu Terakhir</span></h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                                name: 'Pendapatan',
                                data: @json($pendapatanValue)
                            },
                            {
                                name: 'Bersih',
                                data: @json($barangValue)
                            }
                        ],
                        chart: {
                            height: 350,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                        },
                        markers: {
                            size: 4
                        },
                        colors: ['#ff771d', '#2eca6a'],
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            type: 'day',
                            categories: categories
                        },
                        tooltip: {
                            x: {
                                format: 'dd/MM/yy HH:mm'
                            },
                        }
                    }).render();
                });
            </script>
            <!-- End Line Chart -->

        </div>

    </div>
</div>

<div class="col-12">
    <div class="card">

        <div class="card-body">
            <h5 class="card-title">Laporan Penjualan Minggu Terakhir</span></h5>

            <!-- Line Chart -->
            <div id="penjualanChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#penjualanChart"), {
                        series: [{
                                name: 'Barang',
                                data: @json($result)
                            },
                            {
                                name: 'Transaksi',
                                data: @json($weekCount)
                            }
                        ],
                        chart: {
                            height: 350,
                            type: 'area',
                            toolbar: {
                                show: false
                            },
                        },
                        markers: {
                            size: 4
                        },
                        colors: ['#e6d800', '#0bb4ff'],
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2
                        },
                        xaxis: {
                            type: 'day',
                            categories: categories
                        },
                        tooltip: {
                            x: {
                                format: 'dd/MM/yy HH:mm'
                            },
                        }
                    }).render();
                });
            </script>
            <!-- End Line Chart -->

        </div>

    </div>
</div>
