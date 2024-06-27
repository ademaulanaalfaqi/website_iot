@extends('admin.base')
@section('content')
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Edit Data Sensor Tekanan</h5>
                    <div class="card-body">
                        <form action="{{url('edit-sensor-tekanan', $sensortekanan->id)}}" method="post">
                            @csrf
                            <div class="mb-1">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" value="{{$sensortekanan->latitude}}" readonly required/>
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude" value="{{$sensortekanan->longitude}}" readonly required/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan Tempat</label>
                                <input type="text" name="keterangan" class="form-control" placeholder="Detail Tempat Sensor" value="{{$sensortekanan->keterangan}}" required/>
                            </div>
                            <div class="float-end">
                                <button type="button" class="btn btn-danger" id="delete-marker">Hapus Penanda</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
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
    <script>
        var map = L.map('map').setView([-1.830872, 109.988321], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([{{ $sensortekanan->latitude }}, {{ $sensortekanan->longitude }}]).addTo(map);

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

        document.getElementById('delete-marker').addEventListener('click', function() {
            if (marker) {
                map.removeLayer(marker);
                marker = null;
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
            }
        });
    </script>
@endpush
