@extends('admin.base')
@section('content')
    <div class="row mb-3">
        <div class="col-md-5 mb-3">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">pH hari ini</h5>
                        <small class="text-muted">Hitungan pH/jam</small>
                    </div>
                    <form action="{{ url('download-today-report-ph', $sensorph->id) }}" method="POST">
                        @csrf
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <button class="btn dropdown-item" type="submit">Unduh Laporan Hari Ini</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2" id="phValue"></h2>
                            <span>pH</span>
                        </div>
                    </div>
                    <hr>
                    <div class="p-0 m-0">
                        <canvas id="ChartpH"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card mb-3">
                <div class="card-body">
                    <div height="100%" width="10" id="pHperhari"></div>
                </div>
            </div>
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-center">Keterangan</h5>
                            <div class="text-center mb-3" id="phStatus"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div id="map" style="height: 400px; max-width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    Histori Pengukuran
                </h5>
                <form action="{{ url('download-reports-ph', $sensorph->id) }}" method="POST" id="exportForm" class="d-flex">
                    @csrf
                    <div class="input-group">
                        <input type="date" class="form-control" aria-describedby="button-addon2" name="startDate" required>
                        <input type="date" class="form-control" aria-describedby="button-addon2" name="endDate" required>
                        <button class="btn btn-outline-success" type="submit" id="button-addon2">Export</button>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Pengukuran</th>
                            <th class="text-center">pH</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historyLaporan as $reports)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($reports->created_at)->format('d-m-Y H:i:s') }}</td>
                                <td class="text-center">{{ $reports->ph_value }} pH</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('ph')
    <script>
        new DataTable('#datatable');
    </script>
    {{-- peta --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([{{ $sensorph->latitude }}, {{ $sensorph->longitude }}], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([{{ $sensorph->latitude }}, {{ $sensorph->longitude }}]).addTo(map)
                .bindPopup(`<b>{{ $sensorph->sensor }}</b><br>{{ $sensorph->keterangan }}`).openPopup();
        });
    </script>

    {{-- ph description --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function getPHStatus(ph_value) {
                if (ph_value < 6.5) {
                    return '<div class="alert alert-danger">pH air terlalu rendah!!</div>';
                } else if (ph_value >= 6.5 && ph_value <= 8.5) {
                    return '<div class="alert alert-success">pH normal</div>';
                } else {
                    return '<div class="alert alert-danger">pH terlalu tinggi!!</div>';
                }
            }

            function updatePHStatus() {
                const sensorId = '{{ $sensorph->id }}'; // Ganti dengan ID sensor yang sesuai
                const apiUrl = `/api/data_last_ph/${sensorId}`;

                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const latestPH = response.data.ph_value;
                        const statusText = getPHStatus(latestPH);

                        $('#phStatus').html(statusText);
                        // console.log(latestPH);
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            updatePHStatus();
            setInterval(updatePHStatus, 3000);
        });
    </script>

    {{-- gauge dan text last ph --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function updatePHGauge(latestPH) {
                const percentagePH = (latestPH / 14) * 100;

                let fillColor;
                if (latestPH < 6.5) {
                    fillColor = chartColors.danger;
                } else if (latestPH >= 6.5 && latestPH <= 8.5) {
                    fillColor = chartColors.success;
                } else {
                    fillColor = chartColors.danger;
                }

                // Perbarui data chart
                pHperhari.updateOptions({
                    series: [percentagePH],
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            shadeIntensity: 0.5,
                            gradientToColors: [fillColor],
                            inverseColors: true,
                            opacityFrom: 1,
                            opacityTo: 0.5,
                            stops: [30, 70, 100]
                        }
                    },
                    plotOptions: {
                        radialBar: {
                            dataLabels: {
                                value: {
                                    formatter: function() {
                                        return latestPH.toFixed(
                                        1);
                                    }
                                }
                            }
                        }
                    }
                });
            }

            function fetchLastPH() {
                const sensorId = '{{ $sensorph->id }}';
                const apiUrl = `/api/data_last_ph/${sensorId}`;

                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const latestPH = response.data.ph_value;
                            updatePHGauge(latestPH);
                            $('#phValue').text(latestPH.toFixed(1));
                        } else {
                            console.error('Error fetching data:', response.message);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            fetchLastPH();
            setInterval(fetchLastPH, 3000);

            const chartColors = {
                cardBackground: '#f5f5f5',
                textColor: '#333',
                success: '#00ff00',
                danger: '#ff0000'
            };

            // Pengaturan dasar chart
            const options = {
                series: [],
                chart: {
                    type: 'radialBar',
                    height: 240 t
                },
                labels: ['latest pH'],
                plotOptions: {
                    radialBar: {
                        startAngle: -130,
                        endAngle: 130,
                        offsetY: 10,
                        hollow: {
                            size: '55%'
                        },
                        track: {
                            background: chartColors.cardBackground,
                            strokeWidth: '100%'
                        },
                        dataLabels: {
                            name: {
                                fontSize: '15px',
                                fontWeight: 600,
                                offsetY: 15,
                                color: chartColors.textColor,
                                fontFamily: 'Public Sans'
                            },
                            value: {
                                fontSize: '20px',
                                fontWeight: 500,
                                offsetY: -25,
                                color: chartColors.textColor,
                                fontFamily: 'Public Sans',
                                formatter: function() {
                                    return '0.0';
                                }
                            }
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        shadeIntensity: 0.5,
                        gradientToColors: [chartColors.success],
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 0.5,
                        stops: [30, 70, 100]
                    }
                },
                stroke: {
                    dashArray: 5
                },
                grid: {
                    padding: {
                        top: -35,
                        bottom: -10
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    },
                    active: {
                        filter: {
                            type: 'none'
                        }
                    }
                }
            };

            const chartElement = document.querySelector('#pHperhari');
            const pHperhari = new ApexCharts(chartElement, options);

            pHperhari.render();
        });
    </script>

    {{-- script chart pH --}}
    <script>
        var ctx = document.getElementById('ChartpH').getContext('2d');

        var ChartPh = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'pH Air',
                    data: [],
                    borderColor: '#002ca3',
                    borderWidth: 2,
                    backgroundColor: 'rgba(0, 44, 163, 0.2)',
                    fill: true,
                    tension: 0.2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nilai'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Waktu'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                }
            }
        });


        function updateChartPh() {
            $.ajax({
                url: '/api/data_ph_chart/{{ $sensorph->id }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        response.reverse();
                        var labels = response.map(data => data.created_at);
                        var ph_value = response.map(data => data.ph_value);


                        ChartPh.data.labels = labels;
                        ChartPh.data.datasets[0].data = ph_value;

                        ChartPh.update();
                    }
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        setInterval(updateChartPh, 3000);
        updateChartPh();
    </script>
@endpush
