@extends('admin.base')
@section('content')
    
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title pb-4">
                        Tabel Sensor
                        <a href="{{ url('tambah-sensor-debit') }}" class="btn btn-primary float-end">Tambah Sensor</a>
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Keterangan</th>
                                    <th>Debit</th>
                                    <th>Total</th>
                                    <th>Selengkapnya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sensor_debit as $sensor)
                                    <tr data-id="{{$sensor->id}}">
                                        <td>{{ $sensor->id }}</td>
                                        <td>{{ $sensor->keterangan }}</td>
                                        <td id="debit">{{$sensor->debit}} L/min</td>
                                        <td id="total">{{$sensor->total_liter}} L</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{url('detail-sensor-debit', $sensor->id)}}"
                                                    class="btn btn-dark"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-offset="0,4"
                                                    data-bs-placement="top"
                                                    data-bs-html="true"
                                                    title="<span>Detail</span>"><i class="bx bx-info-circle"></i></a>
                                                <a href="{{url('edit-sensor-debit', $sensor->id)}}"
                                                    class="btn btn-warning"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-offset="0,4"
                                                    data-bs-placement="top"
                                                    data-bs-html="true"
                                                    title="<span>Edit</span>"><i class="bx bxs-edit"></i></a>
                                                <button class="btn btn-danger tombol-delete"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-offset="0,4"
                                                    data-bs-placement="top"
                                                    data-bs-html="true"
                                                    data-id="{{$sensor->id}}"
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="map" style="height: 400px; max-width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('debit')
    {{-- datatable --}}
    <script>
        new DataTable('#datatable');
    </script>

    {{-- map --}}
    <script>
        var map = L.map('map').setView([-1.830872, 109.988321], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var sensors = @json($sensor_debit);
        // console.log(sensors);

        sensors.forEach(function(sensor) {
            if (sensor.latitude && sensor.longitude) {
                L.marker([sensor.latitude, sensor.longitude]).addTo(map)
                    .bindPopup(`<b>${sensor.sensor}</b><br>Lat: ${sensor.latitude}<br>Lng: ${sensor.longitude}`);
            }
        });
    </script>

    {{-- update di kolom --}}
    <script>
        function updateDataDebit() {
            $.ajax({
                url: '/api/data_debit',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    response.forEach(sensor => {
                        var row = $('tr[data-id="' + sensor.id + '"]');
                        row.find('#debit').text(sensor.debit + ' L/min');
                        row.find('#total').text(sensor.total_liter + ' L');
                    });
                },
                error: function(error) {
                    console.error('Error fetching sensor data:', error);
                }
            });
        }

        setInterval(updateDataDebit, 10000);

        updateDataDebit();
    </script>

    {{-- swal --}}
    <script>
        $(document).ready(function() {
            $('.tombol-delete').click(function() {
                var sensorId = $(this).data('id');
                var deleteUrl = '/hapus-sensor-debit/' + sensorId;

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
@endpush
