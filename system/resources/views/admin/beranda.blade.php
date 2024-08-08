@extends('admin.base')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3 order-0">
            <div class="card">
                <div class="d-flex row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary my-4">Welcome to Website! 🎉</h5>
                            <p class="mt-2 mb-1">
                                Kamu bisa menjelajahi website ini sekarang.
                            </p>
                            {{-- <div class="btn-group dropend">
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Menu
                                </button>
                                <ul class="dropdown-menu" style="">
                                    <li><a class="dropdown-item" href="{{url('debit')}}">Debit</a></li>
                                    <li><a class="dropdown-item" href="{{url('tekanan')}}">Tekanan</a></li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ url('public') }}/sneat/assets/img/illustrations/man-with-laptop-light.png"
                                height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-12 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{url('public')}}/sneat/assets/img/icons/unicons/water-meter.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Debit</span>
                    <h3 class="card-title mb-2" id="textDebit"></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-12 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{url('public')}}/sneat/assets/img/icons/unicons/pressure-gauge.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Tekanan</span>
                    <h3 class="card-title mb-2" id="pressureText"></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-12 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{url('public')}}/sneat/assets/img/icons/unicons/ph.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">pH</span>
                    <h3 class="card-title mb-2" id="PhText"></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-12 col-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{url('public')}}/sneat/assets/img/icons/unicons/water.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Turbidity</span>
                    <h3 class="card-title mb-2" id="TurbiText"></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div id="map" style="height: 450px"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('beranda')
    <script>
        var map = L.map('map').setView([-1.830872, 109.988321], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var markers = {}; // Object to hold markers

        function updateMarkers(sensors) {
            sensors.forEach(function(sensor) {
                if (sensor.latitude && sensor.longitude) {
                    var tooltipContent = `<b>${sensor.sensor}</b><br>`;

                    if (sensor.debit && sensor.debit.length > 0) {
                        sensor.debit.forEach(function(debit) {
                            tooltipContent += `${debit.nilai_debit} L/min`;
                        });
                    }

                    if (sensor.tekanan && sensor.tekanan.length > 0) {
                        sensor.tekanan.forEach(function(tekanan) {
                            tooltipContent += `${tekanan.nilai_tekanan} psi`;
                        });
                    }

                    if (sensor.ph && sensor.ph.length > 0) {
                        sensor.ph.forEach(function(ph) {
                            tooltipContent += `${ph.ph_value} pH`;
                        });
                    }

                    if (sensor.turbi && sensor.turbi.length > 0) {
                        sensor.turbi.forEach(function(turbi) {
                            tooltipContent += `${turbi.turbi_ntu} NTU`;
                        });
                    }

                    if (markers[sensor.id]) {
                        markers[sensor.id].setLatLng([sensor.latitude, sensor.longitude])
                            .setTooltipContent(tooltipContent);
                    } else {
                        var marker = L.marker([sensor.latitude, sensor.longitude]).addTo(map)
                            .bindTooltip(tooltipContent, {
                                permanent: true
                            }).openTooltip();
                        markers[sensor.id] = marker;
                    }
                }
            });
        }

        function fetchLatestSensorData() {
            $.ajax({
                url: '/api/data-para-sensor',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    updateMarkers(response);
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        fetchLatestSensorData();
        setInterval(fetchLatestSensorData, 10000);
    </script>

    {{-- script ade --}}
    <script>
        $(document).ready(function() {
            function displayAPIText() {
                $.ajax({
                    url: '/api/flow_text/Debit-OaDIw',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            $('#textDebit').text(response.nilai_debit + ' L/min');
                        } else {
                            $('#textDebit').text('Tidak ada data');
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            displayAPIText();

            setInterval(displayAPIText, 10000);
        });
    </script>

    <script>
        $(document).ready(function() {
            function displayAPIPressureText() {
                $.ajax({
                    url: '/api/pressure_text/Tek-E7ifE',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            $('#pressureText').text(response.nilai_tekanan + ' psi');
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

    {{-- script ari --}}
    <script>
        $(document).ready(function() {
            function displayAPIPhText() {
                $.ajax({
                    url: '/api/data_last_ph/pH-kGK',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            $('#PhText').text(response.data.ph_value + ' pH');
                        } else {
                            $('#PhText').text('Tidak ada data');
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            displayAPIPhText();

            setInterval(displayAPIPhText, 3000);
        });
    </script>

<script>
    $(document).ready(function() {
        function displayAPITurbiText() {
            $.ajax({
                url: '/api/data_last_turbi/Tur-0FU',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        $('#TurbiText').text(response.turbi_ntu + ' NTU');
                    } else {
                        $('#TurbiText').text('Tidak ada data');
                    }
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        displayAPITurbiText();

        setInterval(displayAPITurbiText, 3000);
    });
</script>
@endpush
