@php
    $report = $transactions->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sortBy('created_at');
    $pendapatan = $report->map(function ($item) {
        return $item->qty * $item->harga_jual;
    });
    $barang = $report->map(function ($item) {
        return $item->qty * $item->harga_jual - $item->qty * $item->harga_awal;
    });

@endphp

<script>
    console.log(@json($pendapatan))
    console.log(@json($barang))
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
                                data: @json($pendapatan)
                            },
                            {
                                name: 'Barang',
                                data: @json($barang)
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
                        colors: ['#2eca6a', '#ff771d'],
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
                            type: 'datetime',
                            categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z",
                                "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z",
                                "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                                "2018-09-19T06:30:00.000Z"
                            ]
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
