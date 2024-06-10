@extends('admin.base')
@section('content')
    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Statistik Debit Air</h5>
                    <div class="container text-center">
                        <div class="row align-items-center">
                            <div class="col border p-1">
                                <p class="fs-1 m-0" id="apiText" style="color: #566a7f"></p>
                            </div>
                            <p class="m-0 mt-2" style="font-weight: bold">L/min</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <canvas height="7" width="11" id="realTimeLineChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-7 mb-3">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Statistik Tekanan Air</h5>
                    <div class="container text-center">
                        <div class="row align-items-center">
                            <div class="col border p-1">
                                <p class="fs-1 m-0" id="pressureText" style="color: #566a7f"></p>
                            </div>
                            <p class="m-0 mt-2" style="font-weight: bold">psi</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div id="gaugeChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <canvas height="7" width="10" id="pressureChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('debit')
    {{-- script chart flow --}}
    <script>
        // Mendapatkan elemen canvas
        var ctx = document.getElementById('realTimeLineChart').getContext('2d');

        var flowChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Debit Air',
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

        // Fungsi untuk melakukan pembaruan data setiap 5 detik
        function updateChartFlow() {
            $.ajax({
                url: '/api/flow_data', // Ganti dengan URL API yang sesuai di Laravel
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Memeriksa apakah ada data baru yang diterima
                    if (response.length > 0) {
                        response.reverse();
                        var labels = response.map(data => data.created_at);
                        var flowRates = response.map(data => data.flow_rate);

                        // Memperbarui data dan label pada grafik
                        flowChart.data.labels = labels;
                        flowChart.data.datasets[0].data = flowRates;
                        flowChart.update();
                    }
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Memanggil fungsi pembaruan setiap 5 detik
        setInterval(updateChartFlow, 10000); // Ganti dengan interval yang sesuai

        // Panggil fungsi pembaruan pertama kali untuk mengisi data awal
        updateChartFlow();
    </script>

    {{-- script text flow --}}
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengambil data dari API dan menampilkannya
            function displayAPIText() {
                $.ajax({
                    url: '/api/flow_text', // Ganti dengan URL API yang sesuai di Laravel
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Pastikan ada data yang diterima
                        if (response) {
                            // Tampilkan data teks dalam elemen #apiText
                            $('#apiText').text(response);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            // Panggil fungsi untuk menampilkan data pertama kali
            displayAPIText();

            // Set interval untuk memperbarui data setiap beberapa detik
            setInterval(displayAPIText, 10000); // Ganti dengan interval yang sesuai
        });
    </script>

    {{-- script radial bar tekanan --}}
    <script>
        function hitungPersentase(value, max) {
            return ((value/max)*100);
        }

        async function fetchPressureData() {
            try {
                const response = await fetch('/api/pressure_text');
                const data = await response.json();
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
            var hasilPersentase = hitungPersentase(nilaiPressure, maxPressure);
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

        // Fungsi untuk melakukan pembaruan data setiap 5 detik
        function updateChartPressure() {
            $.ajax({
                url: '/api/pressure_data', // Ganti dengan URL API yang sesuai di Laravel
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Memeriksa apakah ada data baru yang diterima
                    if (response.length > 0) {
                        response.reverse();
                        var labels = response.map(data => data.created_at);
                        var pressureRates = response.map(data => data.pressure_rate);

                        // Memperbarui data dan label pada grafik
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

        // Memanggil fungsi pembaruan setiap 5 detik
        setInterval(updateChartPressure, 10000); // Ganti dengan interval yang sesuai

        // Panggil fungsi pembaruan pertama kali untuk mengisi data awal
        updateChartPressure();
    </script>

    {{-- script text tekanan --}}
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengambil data dari API dan menampilkannya
            function displayAPIPressureText() {
                $.ajax({
                    url: '/api/pressure_text', // Ganti dengan URL API yang sesuai di Laravel
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Pastikan ada data yang diterima
                        if (response) {
                            // Tampilkan data teks dalam elemen #apiText
                            $('#pressureText').text(response);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            // Panggil fungsi untuk menampilkan data pertama kali
            displayAPIPressureText();

            // Set interval untuk memperbarui data setiap beberapa detik
            setInterval(displayAPIPressureText, 10000); // Ganti dengan interval yang sesuai
        });
    </script>
@endpush
