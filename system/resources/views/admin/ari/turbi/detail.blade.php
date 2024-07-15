@extends('admin.base')
@section('content')
    <div class="row mb-3">
        <div class="col-md-5 mb-3">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Nilai turbidity air sekarang (NTU)</h5>
                        <small class="text-muted">Hitungan NTU/jam</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                            <a class="dropdown-item" href="{{ url('download-today-report-turbi', $sensorturbi->id) }}">Unduh Laporan Hari
                                Ini</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2" id="turbiNTU"></h2>
                            <span>NTU</span>
                        </div>
                    </div>
                    <hr>
                    <div class="p-0 m-0">
                        <canvas id="ChartTurbidity"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5 class="card-title text-center">Keterangan</h5>
                            <div class="text-center mb-3" id="TurbiStatus"></div>
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
            <h5 class="card-title">
                Histori Pengukuran
            </h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal Pengukuran</th>
                            <th class="text-center">NTU</th>
                            <th class="text-center">v</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historyLaporan as $reports)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $reports->created_at }}</td>
                            <td class="text-center">{{ $reports->turbi_ntu}}</td>
                            <td class="text-center">{{ $reports->turbi_voltage}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('turbidity')
    <script>
        new DataTable('#datatable');
    </script>
    {{-- <script>
        function fetchReportsByDate() {
            var date = $('#reportDate').val();
            $.ajax({
                url: '{{ route('admin.reports.by-date') }}',
                method: 'GET',
                data: { date: date },
                dataType: 'json',
                success: function(response) {
                    var tableBody = $('#reportTableBody');
                    tableBody.empty(); // Kosongkan tabel sebelum menambahkan data baru

                    response.forEach(function(report, index) {
                        var row = `<tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${report.created_at}</td>
                            <td class="text-center"><a href="/download/report/${report.id}" class="btn btn-primary">Unduh</a></td>
                        </tr>`;
                        tableBody.append(row);
                    });
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        $('#fetchReports').on('click', fetchReportsByDate);
    </script> --}}

    {{-- peta --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([{{ $sensorturbi->latitude }}, {{ $sensorturbi->longitude }}], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([{{ $sensorturbi->latitude }}, {{ $sensorturbi->longitude }}]).addTo(map)
                .bindPopup(`<b>{{ $sensorturbi->sensor }}</b><br>{{ $sensorturbi->keterangan }}`).openPopup();
        });
    </script>

    {{-- ph description --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function getTurbiStatus(turbi_ntu) {
                if (turbi_ntu < 10) {
                    return '<div class="alert alert-success">Mantap, Airnye jernih coy!!</div>';
                } else if (turbi_ntu >= 10 && turbi_ntu <= 25) {
                    return '<div class="alert alert-primary">Airnye cukup jernih lah</div>';
                } else {
                    return '<div class="alert alert-danger">Air e lumpur e nin keruh nyeee</div>';
                }
            }

            function updateTurbiStatus() {
                $.ajax({
                    url: '/api/data_last_turbi/{{ $sensorturbi->id }}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const latestTurbi = response.turbi_ntu;
                        const statusText = getTurbiStatus(latestTurbi);

                        $('#TurbiStatus').html(statusText);
                        console.log(latestTurbi);
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            updateTurbiStatus();
            setInterval(updateTurbiStatus, 60000);
        });
    </script>

    {{-- text last turbi --}}
    <script>
        $(document).ready(function() {
            function dataLastTurbi() {
                $.ajax({
                    url: '/api/data_last_turbi/{{ $sensorturbi->id }}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            $('#turbiNTU').text(response.turbi_ntu);
                        } else {
                            $('#turbiNTU').text('Tidak ada data');
                        }
                        console.log(response)
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            dataLastTurbi();

            setInterval(dataLastTurbi, 60000);
        });
    </script>

    {{-- script chart turbi --}}
    <script>
        // Mendapatkan elemen canvas
        var ctx = document.getElementById('ChartTurbidity').getContext('2d');

        var ChartTurbidity = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Kekeruhan Air',
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
                url: '/api/data_turbi_chart/{{ $sensorturbi->id }}', // Ganti dengan URL API yang sesuai di Laravel
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        response.reverse(); // Membalik urutan data jika diperlukan
                        var labels = response.map(data => data.created_at);
                        var turbi_value = response.map(data => data.turbi_ntu);

                        ChartTurbidity.data.labels = labels;
                        ChartTurbidity.data.datasets[0].data = turbi_value;

                        ChartTurbidity.update();
                    }
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        setInterval(updateChartTurbidity, 60000);
        updateChartTurbidity();
    </script>
@endpush
