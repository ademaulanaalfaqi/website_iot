@extends('admin.base')
@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title pb-4">
                        DATA PELANGGAN
                        <a href="{{ url('tambah-pelanggan') }}" class="btn btn-primary float-end"><strong><i
                                    class="bx bx-plus"></i> Tambah Pelanggan</strong></a>
                    </h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>ID</th>
                                    <th>AKSI</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggan as $data)
                                    <tr>
                                        <td scope="row">{{ $data->id }}</td>
                                        <td>
                                            <a href="{{ url('detail-pelanggan', $data->id) }}" class="btn btn-dark"><i
                                                    class="bx bx-info-circle"></i></a>
                                            <a href="{{ url('edit-pelanggan', $data->id) }}" class="btn btn-warning"><i
                                                    class="bx bx-edit"></i></a>
                                            <button type="button" class="btn btn-danger"><i
                                                    class="bx bx-trash"></i></button>
                                        </td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->alamat }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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

@push('meteran')
    {{-- datatable --}}
    <script>
        new DataTable('#datatable');
    </script>

    {{-- peta --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi peta dengan posisi tengah di koordinat rata-rata pelanggan atau koordinat default
            var map = L.map('map').setView([0, 0], 2); // Set view ke koordinat default

            // Tambahkan tile layer dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Data pelanggan dari Laravel
            var pelangganData = @json($pelanggan);

            // Check if pelangganData is not empty
            if (pelangganData.length > 0) {
                // Set view map ke rata-rata koordinat pelanggan pertama
                map.setView([pelangganData[0].latitude, pelangganData[0].longitude], 14);
            }

            // Tambahkan marker untuk setiap pelanggan
            pelangganData.forEach(function(pelanggan) {
                L.marker([pelanggan.latitude, pelanggan.longitude]).addTo(map)
                    .bindPopup(`<b>${pelanggan.sensor}</b><br>${pelanggan.keterangan}`);
            });
        });
    </script>
@endpush
