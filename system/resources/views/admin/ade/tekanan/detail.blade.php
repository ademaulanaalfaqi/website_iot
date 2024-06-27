@extends('admin.base')
@section('content')
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row row-bordered">
                        <div class="col-md-8">
                            <h5 class="card-title">Statistik Tekanan Air</h5>
                            <div class="container text-center">
                                <div class="row align-items-center">
                                    <div class="col border p-1">
                                        <p class="fs-1 m-0" id="pressureText" style="color: #566a7f"></p>
                                    </div>
                                    <p class="m-0 my-2" style="font-weight: bold">psi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="gaugewrap"
                                style="display: flex; align-items: center; justify-content: center; height: 100%;">
                                <div id="gaugeChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <canvas height="7" width="10" id="pressureChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="map" style="height: 400px; max-width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('tekanan')

    {{-- script radial bar tekanan --}}
    <script>
        function hitungPersentase(value, max) {
            return ((value / max) * 100);
        }

        async function fetchPressureData() {
            try {
                const response = await fetch('/api/pressure_text/{{$sensortekanan->id}}');
                const data = await response.json();
                // console.log(data);
                return data;
            } catch (error) {
                console.error('Error fetching pressure data:', error);
                return null;
            }
        }

        let chart;

        async function inisialisasiChart() {
            const nilaiPressure = await fetchPressureData();
            const maxPressure = 50;
            var hasilPersentase = hitungPersentase(nilaiPressure.nilai_tekanan, maxPressure);
            // console.log(nilaiPressure);

            var options = {
                series: [hasilPersentase],
                chart: {
                    type: 'radialBar',
                    offsetY: -20,
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        track: {
                            background: "#e7e7e7",
                            strokeWidth: '97%',
                            margin: 5,
                            dropShadow: {
                                enabled: true,
                                top: 2,
                                left: 0,
                                color: '#999',
                                opacity: 1,
                                blur: 2
                            }
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                offsetY: -2,
                                fontSize: '16px',
                                formatter: function(val) {
                                    return val + '%';
                                }
                            }
                        }
                    }
                },
                grid: {
                    padding: {
                        top: -10
                    }
                },
                fill: {
                    colors: ['#099486']
                },
                labels: ['Average Results'],
            };

            if (!chart) {
                chart = new ApexCharts(document.querySelector("#gaugeChart"), options);
                chart.render();
            } else {
                // Update chart dengan data baru
                chart.updateSeries([hasilPersentase]);
            }
        }
        setInterval(inisialisasiChart, 10000);
        inisialisasiChart();
    </script>

    {{-- script chart tekanan --}}
    <script>
        // Mendapatkan elemen canvas
        var ctx = document.getElementById('pressureChart').getContext('2d');

        var pressureChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Tekanan Air',
                    data: [],
                    borderColor: '#099486',
                    borderWidth: 2,
                    backgroundColor: 'rgba(9, 148, 134, 0.2)',
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

        function updateChartPressure() {
            $.ajax({
                url: '/api/pressure_data/{{$sensortekanan->id}}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        response.reverse();
                        var labels = response.map(data => data.created_at);
                        var pressureRates = response.map(data => data.nilai_tekanan);

                        pressureChart.data.labels = labels;
                        pressureChart.data.datasets[0].data = pressureRates;
                        pressureChart.update();
                    }
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        setInterval(updateChartPressure, 10000);

        updateChartPressure();
    </script>

    {{-- script text tekanan --}}
    <script>
        $(document).ready(function() {
            function displayAPIPressureText() {
                $.ajax({
                    url: '/api/pressure_text/{{$sensortekanan->id}}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            $('#pressureText').text(response.nilai_tekanan);
                        } else {
                            $('#pressureText').text('Tidak ada data');
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            displayAPIPressureText();

            setInterval(displayAPIPressureText, 10000);
        });
    </script>

    {{-- peta --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([{{ $sensortekanan->latitude }}, {{ $sensortekanan->longitude }}], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([{{ $sensortekanan->latitude }}, {{ $sensortekanan->longitude }}]).addTo(map)
                .bindPopup(`<b>{{ $sensortekanan->sensor }}</b><br>{{ $sensortekanan->keterangan }}`).openPopup();
        });
    </script>
@endpush
