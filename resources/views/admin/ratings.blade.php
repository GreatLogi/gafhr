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

    <div class="mb-4 row g-3">
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <div class="card-body">
                    <h6 class="mb-1 text-muted stat-title">{{ $service }} RATINGS</h6>
                    <div class="mb-0 stat-value">{{ number_format($total ?? 0) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <h6 class="mb-3 text-muted stat-title">{{ $service }} RATINGS BY GENDER</h6>
                    <canvas id="ratingGenderChart" height="130"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <h6 class="mb-3 text-muted stat-title">{{ $service }} RATINGS BY RANK</h6>
                    <canvas id="ratingRankChart" height="170"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const genderLabels = @json($genderLabels ?? []);
            const genderCounts = @json($genderCounts ?? []);
            const rankLabels = @json($rankLabels ?? []);
            const rankCounts = @json($rankCounts ?? []);

            const genderCtx = document.getElementById('ratingGenderChart');
            if (genderCtx) {
                new Chart(genderCtx, {
                    type: 'doughnut',
                    data: {
                        labels: genderLabels,
                        datasets: [{
                            data: genderCounts,
                            backgroundColor: ['#1f4b99', '#d94862', '#9aa4b2'],
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

            const rankCtx = document.getElementById('ratingRankChart');
            if (rankCtx) {
                new Chart(rankCtx, {
                    type: 'bar',
                    data: {
                        labels: rankLabels,
                        datasets: [{
                            label: 'Ratings',
                            data: rankCounts,
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
        })();
    </script>
@endsection
