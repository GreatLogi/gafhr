@extends('admin.admin_master')
@section('admin')
    <style>
        .dashboard-shell {
            padding: 6px 2px 18px;
        }

        .section-title {
            font-size: 0.92rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #5c6e86;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .stat-card {
            border: 1px solid rgba(28, 56, 96, 0.1);
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            background: #fff;
            overflow: hidden;
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 34px rgba(19, 33, 68, 0.14);
            border-color: rgba(25, 92, 186, 0.25);
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #20539a;
            background: #e9f0fb;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .stat-title {
            letter-spacing: 0.04em;
            font-weight: 600;
            font-size: 0.77rem;
            text-transform: uppercase;
        }

        .stat-value {
            font-weight: 700;
            font-size: 1.65rem;
            color: #1a2f4f;
            line-height: 1.1;
        }

        .stat-meta {
            font-size: 0.76rem;
            color: #72839b;
            font-weight: 500;
            margin-top: 4px;
        }

        .stat-chip {
            position: absolute;
            right: 12px;
            top: 12px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border-radius: 999px;
            padding: 4px 9px;
            background: #edf3ff;
            color: #24508f;
        }

        .stat-subtle {
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
        }

        .stat-primary {
            background: linear-gradient(145deg, #1a4f95 0%, #2568be 100%);
            color: #fff;
        }

        .stat-primary .stat-value,
        .stat-primary .stat-title,
        .stat-primary .stat-meta {
            color: #fff !important;
        }

        .stat-primary .stat-icon {
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
        }

        .stat-primary .stat-chip {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .chart-accordion .accordion-item {
            border: 0;
            margin-bottom: 14px;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 18px rgba(19, 33, 68, 0.08);
        }

        .chart-accordion .accordion-header {
            background: #f8fafc;
        }

        .chart-accordion .accordion-button {
            font-weight: 600;
            letter-spacing: 0.02em;
            padding: 0.75rem 1rem;
        }

        .chart-accordion .accordion-button:focus {
            box-shadow: none;
        }

        .chart-accordion .accordion-body {
            background: #ffffff;
        }
    </style>

    <div class="dashboard-shell">
    <div class="section-title">Service Overview</div>
    <div class="mb-4 row g-3">
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <span class="stat-chip">Active</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-shield"></i></span>
                    <h6 class="mb-1 text-muted stat-title">ARMY</h6>
                    <div class="mb-0 stat-value">{{ number_format($armyCount ?? 0) }}</div>
                    <div class="stat-meta">Personnel strength</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <span class="stat-chip">Active</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-navigation"></i></span>
                    <h6 class="mb-1 text-muted stat-title">NAVY</h6>
                    <div class="mb-0 stat-value">{{ number_format($navyCount ?? 0) }}</div>
                    <div class="stat-meta">Personnel strength</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <span class="stat-chip">Active</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-wind"></i></span>
                    <h6 class="mb-1 text-muted stat-title">AIRFORCE</h6>
                    <div class="mb-0 stat-value">{{ number_format($airforceCount ?? 0) }}</div>
                    <div class="stat-meta">Personnel strength</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-center card stat-card stat-primary">
                <span class="stat-chip">Total</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-layers"></i></span>
                    <h6 class="mb-1 text-muted stat-title">TOTAL</h6>
                    <div class="mb-0 stat-value">{{ number_format($totalCount ?? 0) }}</div>
                    <div class="stat-meta">All services</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-title">Officers Snapshot</div>
    <div class="mb-4 row g-3">
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <span class="stat-chip">Officer</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-user-check"></i></span>
                    <h6 class="mb-1 text-muted stat-title">ARMY (OFFICER)</h6>
                    <div class="mb-0 stat-value">{{ number_format($armyOfficerCount ?? 0) }}</div>
                    <div class="stat-meta">Commissioned count</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <span class="stat-chip">Officer</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-user-check"></i></span>
                    <h6 class="mb-1 text-muted stat-title">NAVY (OFFICER)</h6>
                    <div class="mb-0 stat-value">{{ number_format($navyOfficerCount ?? 0) }}</div>
                    <div class="stat-meta">Commissioned count</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <span class="stat-chip">Officer</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-user-check"></i></span>
                    <h6 class="mb-1 text-muted stat-title">AIRFORCE (OFFICER)</h6>
                    <div class="mb-0 stat-value">{{ number_format($airforceOfficerCount ?? 0) }}</div>
                    <div class="stat-meta">Commissioned count</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-center card stat-card stat-subtle">
                <span class="stat-chip">Officer</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-users"></i></span>
                    <h6 class="mb-1 text-muted stat-title">TOTAL (OFFICER)</h6>
                    <div class="mb-0 stat-value">{{ number_format($officerTotalCount ?? 0) }}</div>
                    <div class="stat-meta">Combined officers</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-title">Soldier And Rating Snapshot</div>
    <div class="mb-4 row g-3">
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <span class="stat-chip">Soldier</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-user"></i></span>
                    <h6 class="mb-1 text-muted stat-title">ARMY (SOLDIER)</h6>
                    <div class="mb-0 stat-value">{{ number_format($armySoldierCount ?? 0) }}</div>
                    <div class="stat-meta">Enlisted count</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <span class="stat-chip">Soldier</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-user"></i></span>
                    <h6 class="mb-1 text-muted stat-title">AIRFORCE (SOLDIER)</h6>
                    <div class="mb-0 stat-value">{{ number_format($airforceSoldierCount ?? 0) }}</div>
                    <div class="stat-meta">Enlisted count</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-center card stat-card">
                <span class="stat-chip">Rating</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-award"></i></span>
                    <h6 class="mb-1 text-muted stat-title">NAVY (RATING)</h6>
                    <div class="mb-0 stat-value">{{ number_format($navyRatingCount ?? 0) }}</div>
                    <div class="stat-meta">Ratings count</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="text-center card stat-card stat-subtle">
                <span class="stat-chip">Combined</span>
                <div class="card-body">
                    <span class="stat-icon"><i class="feather icon-pie-chart"></i></span>
                    <h6 class="mb-1 text-muted stat-title">TOTAL (SOLDIER+RATING)</h6>
                    <div class="mb-0 stat-value">{{ number_format($soldierTotalCount + $navyRatingCount) }}</div>
                    <div class="stat-meta">All enlisted + ratings</div>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion chart-accordion" id="chartAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="officerChartsHeading">
                <button class="accordion-button" type="button" data-toggle="collapse"
                    data-target="#officerChartsCollapse" aria-expanded="true"
                    aria-controls="officerChartsCollapse">
                    Officer Charts
                </button>
            </h2>
            <div id="officerChartsCollapse" class="accordion-collapse collapse show"
                aria-labelledby="officerChartsHeading" data-bs-parent="#chartAccordion">
                <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-lg-7">
                            <div class="card stat-card h-100">
                                <div class="card-body">
                                    <h6 class="mb-3 text-muted stat-title">OFFICERS BY SERVICE (BAR)</h6>
                                    <canvas id="officerBarChart" height="110"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card stat-card h-100">
                                <div class="card-body">
                                    <h6 class="mb-3 text-muted stat-title">OFFICERS DISTRIBUTION (PIE)</h6>
                                    <canvas id="officerPieChart" height="110"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="soldierChartsHeading">
                <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                    data-target="#soldierChartsCollapse" aria-expanded="false"
                    aria-controls="soldierChartsCollapse">
                    Soldier/Rating Charts
                </button>
            </h2>
            <div id="soldierChartsCollapse" class="accordion-collapse collapse"
                aria-labelledby="soldierChartsHeading" data-bs-parent="#chartAccordion">
                <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-lg-7">
                            <div class="card stat-card h-100">
                                <div class="card-body">
                                    <h6 class="mb-3 text-muted stat-title">SOLDIER/RATING BY SERVICE (BAR)</h6>
                                    <canvas id="soldierRatingBarChart" height="110"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card stat-card h-100">
                                <div class="card-body">
                                    <h6 class="mb-3 text-muted stat-title">SOLDIER/RATING DISTRIBUTION (PIE)</h6>
                                    <canvas id="soldierRatingPieChart" height="110"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            const labels = ['ARMY', 'NAVY', 'AIRFORCE'];
            const data = [
                {{ $armyOfficerCount ?? 0 }},
                {{ $navyOfficerCount ?? 0 }},
                {{ $airforceOfficerCount ?? 0 }},
            ];

            const colors = ['#1f4b99', '#1a7f8f', '#2f8f4e'];

            const barCtx = document.getElementById('officerBarChart');
            if (barCtx) {
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Officers',
                            data,
                            backgroundColor: colors,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }

            const pieCtx = document.getElementById('officerPieChart');
            if (pieCtx) {
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels,
                        datasets: [{
                            data,
                            backgroundColor: colors,
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            const soldierLabels = ['ARMY (SOLDIER)', 'AIRFORCE (SOLDIER)', 'NAVY (RATING)'];
            const soldierData = [
                {{ $armySoldierCount ?? 0 }},
                {{ $airforceSoldierCount ?? 0 }},
                {{ $navyRatingCount ?? 0 }},
            ];
            const soldierColors = ['#8a3ffc', '#ff7a59', '#00a699'];

            const soldierBarCtx = document.getElementById('soldierRatingBarChart');
            if (soldierBarCtx) {
                new Chart(soldierBarCtx, {
                    type: 'bar',
                    data: {
                        labels: soldierLabels,
                        datasets: [{
                            label: 'Soldier/Rating',
                            data: soldierData,
                            backgroundColor: soldierColors,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        }
                    }
                });
            }

            const soldierPieCtx = document.getElementById('soldierRatingPieChart');
            if (soldierPieCtx) {
                new Chart(soldierPieCtx, {
                    type: 'pie',
                    data: {
                        labels: soldierLabels,
                        datasets: [{
                            data: soldierData,
                            backgroundColor: soldierColors,
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        })();
    </script>
@endsection
