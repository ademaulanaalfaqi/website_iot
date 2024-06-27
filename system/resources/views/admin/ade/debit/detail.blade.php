@extends('admin.base')
@section('content')
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Debit Air</h5>
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
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total</h5>
                            <div class="container text-center">
                                <div class="row align-items-center">
                                    <div class="col border p-1">
                                        <p class="fs-1 m-0" id="apiTextTotal" style="color: #566a7f"></p>
                                    </div>
                                    <p class="m-0 mt-2" style="font-weight: bold">L/min</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas height="7" width="11" id="realTimeLineChart"></canvas>
                        </div>
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
    {{-- script chart flow --}}
    <script>
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

        function updateChartFlow() {
            $.ajax({
                url: '/api/flow_data/{{$sensordebit->id}}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        response.reverse();
                        var labels = response.map(data => data.created_at);
                        var flowRates = response.map(data => data.nilai_debit);

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

        setInterval(updateChartFlow, 10000);

        updateChartFlow();
    </script>

    {{-- script text flow --}}
    <script>
        $(document).ready(function() {
            function displayAPIText() {
                $.ajax({
                    url: '/api/flow_text/{{$sensordebit->id}}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            $('#apiText').text(response.nilai_debit);
                            $('#apiTextTotal').text(response.total_liter);
                        } else {
                            $('#apiText').text('Tidak ada data');
                            $('#apiTextTotal').text('Tidak ada data');
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

    {{-- peta --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([{{ $sensordebit->latitude }}, {{ $sensordebit->longitude }}], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([{{ $sensordebit->latitude }}, {{ $sensordebit->longitude }}]).addTo(map)
                .bindPopup(`<b>{{ $sensordebit->sensor }}</b><br>{{ $sensordebit->keterangan }}`).openPopup();
        });
    </script>
@endpush
