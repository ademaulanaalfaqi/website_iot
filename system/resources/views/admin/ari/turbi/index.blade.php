@extends('admin.base')
@section('content')
    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title pb-4">
                        Tabel Sensor Turbidity
                        <buttom type="button" data-bs-toggle="modal" data-bs-target="#modalTambahSensor"
                            class="btn btn-primary float-end">Tambah Sensor</buttom>
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Keterangan Lokasi</th>
                                    <th>Turbidity (NTU)</th>
                                    <th>v</th>
                                    <th>Selengkapnya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sensor_turbi as $sensor)
                                    <tr data-id="{{ $sensor->id }}">
                                        <td>{{ $sensor->id }}</td>
                                        <td>{{ $sensor->keterangan }}</td>
                                        <td id="ntu">{{ $sensor->ntu }} NTU</td>
                                        <td id="voltage">{{ $sensor->voltage }} volt</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ url('detail-sensor-kekeruhan', $sensor->id) }}"
                                                    class="btn btn-icon btn-dark" data-bs-toggle="tooltip"
                                                    data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                    title="<span>Detail</span>"><i class="bx bx-info-circle"></i></a>
                                                <buttton data-bs-toggle="modal"
                                                    data-bs-target="#modalEditSensor{{ $sensor->id }}"
                                                    class="btn btn-icon btn-warning" data-bs-offset="0,4"
                                                    data-bs-placement="top" data-bs-html="true" title="Edit"><i
                                                        class="bx bxs-edit"></i></buttton>
                                                <button class="btn btn-icon btn-danger tombol-delete"
                                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                                    data-bs-html="true" data-id="{{ $sensor->id }}"
                                                    title="<span>Hapus</span>"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" action="" method="post" style="display: none">
                            @csrf
                            @method('delete')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div id="map" style="height: 300px; max-width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add-->
    <div class="modal fade" id="modalTambahSensor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambahkan Sensor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('tambah-sensor-kekeruhan') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-mb-1 col-md-6">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control"
                                    placeholder="Latitude" readonly required />
                            </div>
                            <div class="col-mb-1 col-md-6">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control"
                                    placeholder="Longitude" readonly required />
                            </div>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label">Ketarangan</label>
                            <input type="text" name="keterangan" class="form-control"
                                placeholder="Detail Keterangan Sensor" required />
                        </div>
                        <div class="col-mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div id="mapadd" style="height: 250px; max-width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-danger" id="delete-marker">Hapus Penanda</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit-->
    @foreach ($sensor_turbi as $sensor)
        <div class="modal fade" id="modalEditSensor{{ $sensor->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Edit Keterangan Sensor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ url('edit-sensor-kekeruhan', $sensor->id) }}" method="post">
                        <div class="modal-body">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-mb-1 col-md-6">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" name="latitude" id="latitude{{ $sensor->id }}"
                                        class="form-control" placeholder="Latitude" value="{{ $sensor->latitude }}"
                                        readonly />
                                </div>
                                <div class="col-mb-1 col-md-6">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" name="longitude" id="longitude{{ $sensor->id }}"
                                        class="form-control" placeholder="Longitude" value="{{ $sensor->longitude }}"
                                        readonly />
                                </div>
                            </div>
                                <div class="col mb-3">
                                    <label class="form-label">Ketarangan</label>
                                    <input type="text" name="keterangan" class="form-control"
                                        value="{{ $sensor->keterangan }}" />
                                </div>
                                <div class="col mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="mapedit{{ $sensor->id }}" style="height: 400px; max-width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('turbidity')
    {{-- datatable --}}
    <script>
        new DataTable('#datatable');
    </script>

    {{-- map --}}
    <script>
        var map = L.map('map').setView([-1.830872, 109.988321], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var sensors = @json($sensor_turbi);

        sensors.forEach(function(sensor) {
            if (sensor.latitude && sensor.longitude) {
                L.marker([sensor.latitude, sensor.longitude]).addTo(map)
                    .bindPopup(`<b>${sensor.sensor}</b><br>Lat: ${sensor.latitude}<br>Lng: ${sensor.longitude}`);
            }
        });
    </script>


    {{-- map add --}}
    <script>
        var mapadd;
        var marker;

        function initMapAdd() {
            mapadd = L.map('mapadd').setView([-1.830872, 109.988321], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapadd);

            mapadd.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(mapadd);
                }

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });

            document.getElementById('delete-marker').addEventListener('click', function() {
                if (marker) {
                    mapadd.removeLayer(marker);
                    marker = null;
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                }
            });
        }

        $('#modalTambahSensor').on('shown.bs.modal', function() {
            setTimeout(function() {
                mapadd.invalidateSize();
            }, 100);
        });

        $('#modalTambahSensor').on('show.bs.modal', function() {
            initMapAdd();
        });
    </script>

    {{-- update di row --}}
    <script>
        function updateDataTurbi() {
            $.ajax({
                url: '/api/data_turbi',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    response.forEach(sensor => {
                        var row = $('tr[data-id="' + sensor.id + '"]');
                        row.find('#ntu').text(sensor.ntu + ' NTU');
                        row.find('#voltage').text(sensor.voltage + ' volt');
                    });
                },
                error: function(error) {
                    console.error('Error fetching sensor data:', error);
                }
            });
        }

        setInterval(updateDataTurbi, 10000);

        updateDataTurbi();
    </script>

    {{-- swal --}}
    <script>
        $(document).ready(function() {
            $('.tombol-delete').click(function() {
                var sensorId = $(this).data('id');
                var deleteUrl = '/hapus-sensor-kekeruhan/' + sensorId;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda tidak dapat mengembalikan ini!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#002ca3',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-delete').attr('action', deleteUrl).submit();
                    }
                });
            });
        });
    </script>
    {{-- Map edit --}}
    <script>
        function initMapEdit(sensorId, latitude, longitude) {
            var mapedit = L.map('mapedit' + sensorId).setView([latitude, longitude], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapedit);

            var marker = L.marker([latitude, longitude]).addTo(mapedit);

            mapedit.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(mapedit);
                }

                document.getElementById('latitude' + sensorId).value = lat;
                document.getElementById('longitude' + sensorId).value = lng;
            });

            // Invalidate size after the map is fully shown
            setTimeout(function() {
                mapedit.invalidateSize();
            }, 100);
        }

        function bindModalEvents(sensor) {
            $('#modalEditSensor' + sensor.id).on('shown.bs.modal', function() {
                initMapEdit(sensor.id, sensor.latitude, sensor.longitude);
            });
        }

        @foreach ($sensor_turbi as $sensor)
            bindModalEvents(@json($sensor));
        @endforeach
    </script>
@endpush
