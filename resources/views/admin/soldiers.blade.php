@extends('admin.admin_master')
@section('admin')
    <style>
        .stat-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 14px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 26px rgba(19, 33, 68, 0.12);
            border-color: rgba(0, 0, 0, 0.08);
        }

        .stat-title {
            letter-spacing: 0.04em;
            font-weight: 600;
        }

        .stat-value {
            font-weight: 700;
            font-size: 1.4rem;
        }
    </style>

    @foreach ($serviceCharts as $chart)
        <div class="mb-4 row g-3">
            <div class="col-md-3">
                <div class="text-center card stat-card">
                    <div class="card-body">
                        <h6 class="mb-1 text-muted stat-title">{{ $chart['service'] }} SOLDIERS</h6>
                        <div class="mb-0 stat-value">{{ number_format($chart['total'] ?? 0) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4 row g-3">
            <div class="col-lg-6">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <h6 class="mb-3 text-muted stat-title">{{ $chart['service'] }} SOLDIERS BY GENDER</h6>
                        <canvas id="soldierGenderChart-{{ strtolower($chart['service']) }}" height="130"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <h6 class="mb-3 text-muted stat-title">{{ $chart['service'] }} SOLDIERS BY RANK</h6>
                        <canvas id="soldierRankChart-{{ strtolower($chart['service']) }}" height="170"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const serviceCharts = @json($serviceCharts ?? []);
            const genderColors = ['#1f4b99', '#d94862', '#9aa4b2'];

            serviceCharts.forEach((chart) => {
                const serviceKey = String(chart.service || '').toLowerCase();

                const genderCtx = document.getElementById(`soldierGenderChart-${serviceKey}`);
                if (genderCtx) {
                    new Chart(genderCtx, {
                        type: 'doughnut',
                        data: {
                            labels: chart.genderLabels || [],
                            datasets: [{
                                data: chart.genderCounts || [],
                                backgroundColor: genderColors,
                                borderWidth: 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' }
                            }
                        }
                    });
                }

                const rankCtx = document.getElementById(`soldierRankChart-${serviceKey}`);
                if (rankCtx) {
                    new Chart(rankCtx, {
                        type: 'bar',
                        data: {
                            labels: chart.rankLabels || [],
                            datasets: [{
                                label: 'Soldiers',
                                data: chart.rankCounts || [],
                                backgroundColor: '#1a7f8f',
                                borderRadius: 6,
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });
                }
            });
        })();
    </script>
@endsection
