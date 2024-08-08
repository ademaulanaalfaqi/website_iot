@extends('admin.base')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Grafik Volume Air</h5>
                    <canvas id="chartMeter" height="150"></canvas>
                    {{-- <button class="btn btn-outline-danger" type="" id="button-addon2">Nyala/Mati</button> --}}
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
    <div class="row">
        <div class="col-md-12 mb-3 mt-4">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row row-bordered">
                        <div class="table-responsive text-nowrap">
                            <div class="col-md-12">
                                <h5 class="card-title">Detail Data Pelanggan dan Sensor</h5>
                                <form action="{{ url('export-data-sensor-pelanggan', $pelanggan->id) }}" method="POST"
                                    id="exportForm">
                                    @csrf
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" aria-describedby="button-addon2"
                                            name="export_date">
                                        <button class="btn btn-outline-success" type="submit"
                                            id="button-addon2">Export</button>
                                    </div>
                                </form>
                                <table class="table">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat</th>
                                            <th>Tarif/M³</th>
                                            <th>Id Sensor</th>
                                            <th>Jenis Alat Sensor</th>
                                            <th>Keterangan Lokasi Sensor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $pelanggan->nama }}</td>
                                            <td>{{ $pelanggan->alamat }}</td>
                                            <td>Rp. {{ $totalBiaya }}</td>
                                            <td>{{ $pelanggan->id }}</td>
                                            <td>{{ $pelanggan->sensor }}</td>
                                            <td>{{ $pelanggan->keterangan }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('meteran')
    {{-- script chart meteran --}}

    <script>
        // Mendapatkan elemen canvas
        var ctx = document.getElementById('chartMeter').getContext('2d');

        var ChartMeter = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Volume Air',
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
                            text: 'Volume'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Waktu Indonesia Barat'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                }
            }
        });

        function updateChartMeter(id_pelanggan) {
            $.ajax({
                url: '{{ url('meter-data') }}/${id_pelanggan}', // URL di Laravel
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        response.reverse(); // Membalik urutan data jika diperlukan

                        // Memformat created_at menjadi waktu Indonesia bagian barat (WIB)
                        var labels = response.map(data => {
                            var date = new Date(data.created_at);
                            var localDate = new Date(date.getTime() + (7 * 60 * 60 * 1000)); // GMT+7
                            return localDate.toLocaleString(
                                'id-ID', { // Gunakan 'id-ID' untuk format Indonesia
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                });
                        });

                        var volume = response.map(data => data.volume);

                        // Memperbarui data dan label pada grafik
                        ChartMeter.data.labels = labels;
                        ChartMeter.data.datasets[0].data = volume;

                        ChartMeter.update();
                    }
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }


        setInterval(updateChartMeter, 1000); // Setiap 1 detik
        updateChartMeter();
    </script>

    {{-- peta --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([{{ $pelanggan->latitude }}, {{ $pelanggan->longitude }}], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([{{ $pelanggan->latitude }}, {{ $pelanggan->longitude }}]).addTo(map)
                .bindPopup(`<b>{{ $pelanggan->sensor }}</b><br>{{ $pelanggan->keterangan }}`).openPopup();
        });
    </script>
@endpush
