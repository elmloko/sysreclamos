@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistema de Información y Reclamos de la AGBC</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalClaims }}</h3>
                    <p>Total Reclamos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalComplaints }}</h3>
                    <p>Total Quejas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalInformation }}</h3>
                    <p>Total Informaciones</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalSuggestions }}</h3>
                    <p>Total Sugerencias</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Registros por Día</h3>
                </div>
                <div class="card-body">
                    <canvas id="combinedChart" style="max-width: 800px; height: 400px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Registros por Mes</h3>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" style="max-width: 800px; height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Obtener los datos pasados desde el backend como arreglos
            var claimsPerDay = @json($claimsPerDay);
            var complaintsPerDay = @json($complaintsPerDay);
            var informationPerDay = @json($informationPerDay);
            var suggestionsPerDay = @json($suggestionsPerDay);

            // Función para mapear fechas y totales
            function getDataSet(perDayData) {
                return {
                    labels: perDayData.map(item => item.date),
                    data: perDayData.map(item => item.total)
                };
            }

            // Crear el gráfico con múltiples datasets
            var ctx = document.getElementById('combinedChart').getContext('2d');
            var combinedChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: informationPerDay.map(item => item.date), // Utilizamos las fechas de una tabla, las fechas deben coincidir
                    datasets: [
                        {
                            label: 'Reclamos por Día',
                            data: getDataSet(claimsPerDay).data,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            fill: true
                        },
                        {
                            label: 'Quejas por Día',
                            data: getDataSet(complaintsPerDay).data,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            fill: true
                        },
                        {
                            label: 'Informaciones por Día',
                            data: getDataSet(informationPerDay).data,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: true
                        },
                        {
                            label: 'Sugerencias por Día',
                            data: getDataSet(suggestionsPerDay).data,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Obtener los datos pasados desde el backend como arreglos
            var claimsPerMonth = @json($claimsPerMonth);
            var complaintsPerMonth = @json($complaintsPerMonth);
            var informationPerMonth = @json($informationPerMonth);
            var suggestionsPerMonth = @json($suggestionsPerMonth);

            // Función para mapear meses y totales
            function getDataSet(perMonthData) {
                return {
                    labels: perMonthData.map(item => item.month),
                    data: perMonthData.map(item => item.total)
                };
            }

            // Crear el gráfico con múltiples datasets
            var ctx = document.getElementById('monthlyChart').getContext('2d');
            var monthlyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: informationPerMonth.map(item => item.month), // Utilizamos los meses de una tabla, ya que las fechas deben coincidir
                    datasets: [
                        {
                            label: 'Reclamos por Mes',
                            data: getDataSet(claimsPerMonth).data,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            fill: true
                        },
                        {
                            label: 'Quejas por Mes',
                            data: getDataSet(complaintsPerMonth).data,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            fill: true
                        },
                        {
                            label: 'Informaciones por Mes',
                            data: getDataSet(informationPerMonth).data,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: true
                        },
                        {
                            label: 'Sugerencias por Mes',
                            data: getDataSet(suggestionsPerMonth).data,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@stop
