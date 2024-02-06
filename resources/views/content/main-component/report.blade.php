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

    $pendapatanMonth = [];
    $bersihMonth = [];
    $pengeluaranMonth = [];

    $result = array_values($result);

    $report = $transactions->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sortBy('created_at');
    $thisMonth = $transactions
        ->where('created_at', '>=', now()->subDays(30))
        ->where('created_at', '<=', now())
        ->sortBy('created_at');
    $shopingMonth = $belanja
        ->where('created_at', '>=', now()->subDays(30))
        ->where('created_at', '<=', now())
        ->sortBy('created_at');

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

    $thisMonth
        ->groupBy(function ($transaction) {
            $date = Carbon\Carbon::parse($transaction->created_at);
            return $date->format('l, d-m-Y');
        })
        ->map(function ($group, $dateTime) use (&$pendapatanMonth, &$bersihMonth) {
            [$dayName, $date] = explode(', ', $dateTime, 2);
            $pendapatanMonth[$dateTime] = $group->sum(function ($transaction) {
                return $transaction->qty * $transaction->harga_jual;
            });
            $bersihMonth[$dateTime] = $group->sum(function ($transaction) {
                return $transaction->qty * $transaction->harga_jual - $transaction->qty * $transaction->harga_awal;
            });
        });

    $shopingMonth
        ->groupBy(function ($shop) {
            $date = Carbon\Carbon::parse($shop->created_at);
            return $date->format('l, d-m-Y');
        })
        ->map(function ($group, $dateTime) use (&$pengeluaranMonth) {
            [$dayName, $date] = explode(', ', $dateTime, 2);
            $pengeluaranMonth[$dateTime] = $group->sum(function ($shop) {
                return $shop->qty * $shop->harga_awal;
            });
        });

    $weekCount = array_values($weekCount);
    $pendapatanValue = array_values($pendapatanValue);
    $barangValue = array_values($barangValue);

    $allDays = [];
    $monthStart = Carbon\Carbon::now()->subDays(30);
    for ($i = 0; $i < 30; $i++) {
        $allDays[
            $monthStart
                ->copy()
                ->addDays($i)
                ->format('l, d-m-Y')
        ] = 0;
    }
    $pendapatanMonth = array_merge($allDays, $pendapatanMonth);
    $bersihMonth = array_merge($allDays, $bersihMonth);
    $pengeluaranMonth = array_merge($allDays, $pengeluaranMonth);

    for ($i = 0; $i < 30; $i++) {
        $current = $monthStart
            ->copy()
            ->addDays($i)
            ->format('l, d-m-Y');
        if ($pendapatanMonth[$current] != 0 || $bersihMonth[$current] != 0 || $pengeluaranMonth[$current] != 0) {
            break;
        }

        unset($pendapatanMonth[$current]);
        unset($bersihMonth[$current]);
        unset($pengeluaranMonth[$current]);
    }

@endphp

<script>
    console.log(@json($pendapatanMonth))
    console.log(@json($bersihMonth))
    console.log(@json($pengeluaranMonth))
    var categories = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']
</script>

<div class="col-12">
    <div class="card">

        <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                </li>

                <li><button onclick="pendapatanMinggu()" class="dropdown-item">Minggu</button></li>
                <li><button onclick="pendapatanBulan()" class="dropdown-item">Bulan</button></li>
            </ul>
        </div>

        <div class="card-body">
            <h5 id='chart-pendapatan-desc' class="card-title">Laporan Pendapatan Minggu Terakhir</span>
            </h5>

            <!-- Line Chart -->
            <div id="reportsChart"></div>

            <script>
                let reportsChart;

                function isChartGenerated(id) {
                    return document.getElementById(id) !== null;
                }

                function pendapatanMinggu(event) {
                    document.querySelector('#chart-pendapatan-desc').textContent = 'Laporan Pendapatan Minggu Terakhir';
                    renderChart('reportsChart', [{
                                name: 'Pendapatan',
                                data: @json($pendapatanValue)
                            },
                            {
                                name: 'Bersih',
                                data: @json($barangValue)
                            },
                        ],
                        categories, categories.length);
                }

                function pendapatanBulan(event) {
                    document.querySelector('#chart-pendapatan-desc').textContent = 'Laporan Pendapatan 30 Hari Terakhir';
                    renderChart('reportsChart', [{
                            name: 'Pendapatan',
                            data: Object.values(@json($pendapatanMonth)).map(obj => obj)
                        }, {
                            name: 'Bersih',
                            data: Object.values(@json($bersihMonth)).map(obj => obj)
                        }, {
                            name: 'Pengeluaran',
                            data: Object.values(@json($pengeluaranMonth)).map(obj => obj)
                        }],
                        Object.keys((@json($pendapatanMonth))), categories.length);
                }

                // Object to store references to chart instances
                let chartInstances = {};

                function renderChart(id, data, key, state) {
                    let chartElement = document.getElementById(id);

                    if (chartElement && chartInstances[id]) {
                        // If chart already exists, update it
                        let chart = chartInstances[id];
                        chart.updateSeries(data);
                        chart.updateOptions({
                            xaxis: {
                                categories: key,
                                labels: {
                                    show: state > 10 ? false : true
                                }
                            },
                            tooltip: {
                                x: {
                                    format: 'dd/MM/yy HH:mm'
                                },
                                shared: true,
                                formatter: function(value, {
                                    series,
                                    seriesIndex,
                                    dataPointIndex,
                                    w
                                }) {
                                    // Format the tooltip value here
                                    return value.toLocaleString(); // Format with thousands separator
                                }
                            }
                        });
                    } else {
                        // If chart doesn't exist, create new chart
                        let chart = new ApexCharts(document.querySelector(`#${id}`), {
                            series: data,
                            chart: {
                                height: 350,
                                type: 'line',
                                zoom: {
                                    enabled: false
                                }
                            },
                            // colors: ['#ff771d', '#2eca6a'],
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'straight',
                                width: 3
                            },
                            xaxis: {
                                type: 'day',
                                categories: key,
                                labels: {
                                    show: true
                                }
                            },
                            tooltip: {
                                x: {
                                    format: 'dd/MM/yy HH:mm'
                                },
                                shared: true,
                                formatter: function(value, {
                                    series,
                                    seriesIndex,
                                    dataPointIndex,
                                    w
                                }) {
                                    // Format the tooltip value here
                                    return value.toLocaleString(); // Format with thousands separator
                                }
                            }
                        });

                        chartInstances[id] = chart; // Store reference to the new chart instance
                        chart.render();
                    }
                }


                // function renderChart(data, key, event) {
                //     if (!reportsChart) {
                //         reportsChart = new ApexCharts(document.querySelector("#reportsChart"), {
                //             series: data,
                //             chart: {
                //                 id: 'reportChart',
                //                 height: 350,
                //                 type: 'line',
                //                 zoom: {
                //                     enabled: false
                //                 }
                //             },
                //             dataLabels: {
                //                 enabled: false
                //             },
                //             stroke: {
                //                 curve: 'straight'
                //             },
                //             grid: {
                //                 row: {
                //                     colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                //                     opacity: 0.5
                //                 },
                //             },
                //             xaxis: {
                //                 categories: key,
                //             }
                //         }).render();
                //     } else {
                //         reportsChart.updateOptions()
                //     }
                // }

                // function renderChart(id, data, key, state) {
                //     if (!reportsChart) {
                //         // If chart instance doesn't exist, create a new chart instance
                //         reportsChart = new ApexCharts(document.querySelector(`#${id}`), {
                //             series: data,
                //             chart: {
                //                 height: 350,
                //                 type: 'line',
                //                 zoom: {
                //                     enabled: false
                //                 }
                //             },
                //             // colors: ['#ff771d', '#2eca6a'],
                //             dataLabels: {
                //                 enabled: false
                //             },
                //             stroke: {
                //                 curve: 'straight',
                //                 width: 3
                //             },
                //             xaxis: {
                //                 type: 'day',
                //                 categories: key,
                //                 labels: {
                //                     show: true
                //                 }
                //             },
                //             tooltip: {
                //                 x: {
                //                     format: 'dd/MM/yy HH:mm'
                //                 },
                //                 shared: true,
                //                 formatter: function(value, {
                //                     series,
                //                     seriesIndex,
                //                     dataPointIndex,
                //                     w
                //                 }) {
                //                     // Format the tooltip value here
                //                     return value.toLocaleString(); // Format with thousands separator
                //                 }
                //             }
                //         });

                //         // Render the chart
                //         reportsChart.render();
                //     } else {
                //         reportsChart.updateSeries(data);
                //         reportsChart.updateOptions({
                //             xaxis: {
                //                 categories: key,
                //                 labels: {
                //                     show: state > 10 ? false : true
                //                 }
                //             },
                //             tooltip: {
                //                 x: {
                //                     format: 'dd/MM/yy HH:mm'
                //                 },
                //                 shared: true
                //             }
                //         });
                //     }
                // }

                pendapatanMinggu();
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
                renderChart('penjualanChart', [{
                        name: 'Barang',
                        data: @json($result)
                    },
                    {
                        name: 'Transaksi',
                        data: @json($weekCount)
                    }
                ], categories, @json($weekCount).length);
            </script>
            <!-- End Line Chart -->

        </div>

    </div>
</div>
