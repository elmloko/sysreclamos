<div class="card">
    <div class="card-header">
        <h3 class="card-title">Conteo Diario</h3>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="dailyCountsChart" style="height: 250px;"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        var ctx = document.getElementById('dailyCountsChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($dailyCounts['claims'])) !!}, // Fechas
                datasets: [
                    {
                        label: 'Claims',
                        data: {!! json_encode(array_values($dailyCounts['claims'])) !!},
                        borderColor: 'rgba(60,141,188,0.8)',
                        backgroundColor: 'rgba(60,141,188,0.5)',
                        fill: true,
                    },
                    {
                        label: 'Complaints',
                        data: {!! json_encode(array_values($dailyCounts['complaints'])) !!},
                        borderColor: 'rgba(210, 214, 222, 1)',
                        backgroundColor: 'rgba(210, 214, 222, 0.5)',
                        fill: true,
                    },
                    {
                        label: 'Information',
                        data: {!! json_encode(array_values($dailyCounts['information'])) !!},
                        borderColor: 'rgba(0, 166, 90, 1)',
                        backgroundColor: 'rgba(0, 166, 90, 0.5)',
                        fill: true,
                    },
                    {
                        label: 'Suggestions',
                        data: {!! json_encode(array_values($dailyCounts['suggestions'])) !!},
                        borderColor: 'rgba(243, 156, 18, 1)',
                        backgroundColor: 'rgba(243, 156, 18, 0.5)',
                        fill: true,
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltipFormat: 'll',
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
