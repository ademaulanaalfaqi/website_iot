@extends('admin.base')
@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="row row-bordered g-0">
                <div class="col-md-12">
                    <div class="card-body">
                        <canvas id="ChartpH"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="row row-bordered g-0">
                <div class="col-md-12">
                    <div class="mb-4 mt-4">
                        <canvas id="ChartTurbidity"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ url('public') }}/sneat/assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ url('public') }}/sneat/assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="row row-bordered g-0">
                <div class="col-md-12">
                    <div class="card-body">
                        <div id="pHperhari"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="small fw-semibold">Turbidity Per Hari</div>
                <div class="demo-vertical-spacing">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100">
                            25%
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            50%
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            75%
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            100%
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            75%
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            75%
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            75%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('kualitas')
    {{-- script chart flow --}}
    <script>
        // Mendapatkan elemen canvas
        var ctx = document.getElementById('ChartpH').getContext('2d');

        var flowChart = new Chart(ctx, {
            type: 'line',
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
        // Warna dan konfigurasi chart
        const chartColors = {
            cardBackground: '#f5f5f5', // Ganti dengan warna latar belakang card
            textColor: '#333', // Ganti dengan warna teks
            primary: '#099486' // Ganti dengan warna utama
        };
    
        // Data pengukuran pH air (misalnya)
        const pHData = [7.0, 7.2, 6.8, 7.1, 7.3]; // Contoh data pH, ganti dengan data sesungguhnya
    
        // Ambil nilai pH terbaru
        const latestPH = pHData[pHData.length - 1];
    
        // Pengaturan dasar chart
        const options = {
            series: [latestPH], // Data yang ditampilkan (nilai pH terbaru)
            chart: {
                type: 'radialBar', // Tipe chart
                height: 240 // Tinggi chart
            },
            labels: ['pH/hari'], // Label chart
            plotOptions: {
                radialBar: {
                    startAngle: -130, // Sudut awal chart
                    endAngle: 130, // Sudut akhir chart
                    offsetY: 10, // Offset vertikal
                    hollow: {
                        size: '55%' // Ukuran hollow di tengah
                    },
                    track: {
                        background: chartColors.cardBackground, // Warna latar lintasan
                        strokeWidth: '100%' // Lebar garis lintasan
                    },
                    dataLabels: {
                        name: {
                            fontSize: '15px', // Ukuran font label nama
                            fontWeight: 600, // Ketebalan font label nama
                            offsetY: 15, // Offset vertikal label nama
                            color: chartColors.textColor, // Warna label nama
                            fontFamily: 'Public Sans' // Keluarga font
                        },
                        value: {
                            fontSize: '20px', // Ukuran font label nilai
                            fontWeight: 500, // Ketebalan font label nilai
                            offsetY: -25, // Offset vertikal label nilai
                            color: chartColors.textColor, // Warna label nilai
                            fontFamily: 'Public Sans', // Keluarga font
                            formatter: function (val) {
                                return val.toFixed(1); // Format nilai pH dengan satu tempat desimal
                            }
                        }
                    },
                    max: 10 // Nilai maksimum untuk pH
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.5,
                    gradientToColors: [chartColors.primary],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 0.5,
                    stops: [30, 70, 100]
                }
            },
            stroke: {
                dashArray: 5 // Pola garis putus-putus
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
    
        // Inisialisasi chart
        const chartElement = document.querySelector('#pHperhari');
        const pHperhari = new ApexCharts(chartElement, options);
    
        // Render chart
        pHperhari.render();
    </script>
    
    

    {{-- script chart tekanan --}}
    <script>
        // Mendapatkan elemen canvas
        var ctx = document.getElementById('ChartTurbidity').getContext('2d');

        var ChartTurbidity = new Chart(ctx, {
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
        function updateChartTurbidity() {
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
        setInterval(updateChartTurbidity, 10000); // Ganti dengan interval yang sesuai

        // Panggil fungsi pembaruan pertama kali untuk mengisi data awal
        updateChartTurbidity();
    </script>

    {{-- script text flow --}}
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