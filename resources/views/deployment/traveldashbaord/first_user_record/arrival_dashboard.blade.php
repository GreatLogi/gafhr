@extends('admin.dashboard_master')
@section('admin')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <style>
        .custom-card-height {
            height: 115px;
        }

        .card-body {
            padding: 0.5rem !important;
        }

        .me-1 {
            margin-right: 0.25rem;
        }

        .btn-group {
            width: 100%;
            justify-content: space-between;
        }

        .d-flex.align-items-center.mb-1 {
            display: flex;
            align-items: center;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .btn-group .btn {
            flex: 1;
        }

        .btn-group a {
            color: white;
            text-decoration: none;
        }

        .outer {
            position: relative;
            top: 80px;
            color: white;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            font-size: 20px;
            position: sticky;
            top: 0;
        }

        tr:hover {
            background-color: #ccc;
        }

        tr[data-href] {
            cursor: pointer;
        }

        td {
            font-size: 19px;
            font-weight: bold;
        }

        .highlight {
            background: yellow;
            color: white;
        }
    </style>

    <div class="row" style="margin-top: -150px">
        <!-- customar project  start -->
        <div class="col-xl-2 col-md-6">
            <a href="{{ route('approve-standby-departures') }}">
                <div class="card card-border-c-yellow custom-card-height">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="row align-items-center m-l-0">
                            <div class="col-auto">
                                <i class="fas fa-user-check f-36 text-c-yellow"></i>
                            </div>
                            <div class="col-auto">
                                <h5 style="color:#e3a229">STANDBY</h5>
                                <h2 style="color:#e3a229">{{ $standby }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-md-6">
            <a href="{{ route('approve-pending-departures') }}">
                <div class="card card-border-c-blue custom-card-height">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div class="row align-items-center m-l-0">
                            <div class="col-auto">
                                <i class="fas fa-plane-departure f-36 text-c-blue"></i>
                            </div>
                            <div class="col-auto">
                                <h5 style="color:#0722f5">DEPARTURE (P)</h5>
                                <h2 style="color:#0722f5">{{ $dependings }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-md-6">
            <div class="card card-border-c-green custom-card-height">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <a href="{{ route('approve-arrival-returns') }}">
                        <div class="row align-items-center m-l-0">
                            <div class="col-auto">
                                <i class="fas fa-plane-arrival f-36 text-c-green"></i>
                            </div>
                            <div class="col-auto">
                                <h5 style="color:rgb(115, 185, 44)">ARRIVAL (P)</h5>
                                <h2 style="color:rgb(115, 185, 44)">{{ $departures }}</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6">
            <div class="card card-border-c-red custom-card-height">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <a href="{{ route('personnel-returns') }}">
                        <div class="row align-items-center m-l-0">
                            <div class="col-auto">
                                <i class="fas fa-user-clock f-36 text-c-red"></i>
                            </div>
                            <div class="col-auto">
                                <h5 style="color:rgb(235, 57, 57)">RETURNED</h5>
                                <h2 style="color:rgb(235, 57, 57)">{{ $returned }}</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card card-border-c-black custom-card-height">
                <div class="card-body p-2 d-flex flex-column justify-content-center">
                    <h6 class="text-center">ACTIVITY PERIOD
                        <a href="{{ route('admin.index') }}" class="badge badge-secondary">
                            <i class="feather icon-home"></i>HOME
                        </a>
                    </h6>
                    <div class="row align-items-center m-l-0">
                        <div class="col-12">
                            <form id="filter-form" method="POST"
                                action="{{ route('report-filter-base-on-monthly-weekly-daily') }}">
                                @csrf
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="btn-group" role="group" aria-label="button groups">
                                        <button type="button" class="btn btn-secondary" id="filter-today">TODAY</button>
                                        <button type="button" class="btn btn-secondary" id="filter-week">WEEK</button>
                                        <button type="button" class="btn btn-secondary" id="filter-month">MONTH</button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <div class="me-1 d-flex align-items-center">
                                        <label for="startDatePicker" class="me-1">From:</label>
                                        <input type="date" id="startDatePicker" name="startDatePicker"
                                            class="form-control form-control-sm" placeholder="Start Date" required>
                                    </div>
                                    <div class="me-1 d-flex align-items-center">
                                        <label for="endDatePicker" class="me-1">To:</label>
                                        <input type="date" id="endDatePicker" name="endDatePicker"
                                            class="form-control form-control-sm" placeholder="End Date" required>
                                    </div>
                                    <button type="button" class="badge badge-primary btn-sm"
                                        id="filter-range">Filter</button>
                                </div>
                                <input type="hidden" id="startDate" name="startDate">
                                <input type="hidden" id="endDate" name="endDate">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body py-2 text-center">
            <h4 id="current-date-time" style="color: #0d187d; display: inline;">
                OVERVIEW OF TRAVEL DETAILS AS AT
            </h4>
            <a href="{{ route('travel-dash') }}" class="badge badge-info" style="display: inline;">GO TO DASHBOARD</a>
        </div>
    </div>

    <div class="card bg-pattern">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card user-profile-list">
                    <div class="card-body">
                        <div class="row align-items-center m-l-0">
                            <div class="dt-responsive table-responsive">
                                <div class="dt-responsive table-responsive">
                                    <table id="pending-arrival" class="table table-striped table-bordered nowrap">
                                        <thead>
                                            <tr>
                                                <th>
                                                    No.
                                                </th>
                                                <th>#SVC ID</th>
                                                <th>RANK</th>
                                                <th>PERSONNEL</th>
                                                <th>GENDER</th>
                                                <th>COUNTRY</th>
                                                <th>DEPARTURE DATE</th>
                                                <th>DAYS LEFT TO RETURN</th>
                                                <th>STATUS</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            var dataTable = $('#pending-arrival').DataTable({
                dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                buttons: [],
                scrollY: 960,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: "{{ route('api-first-user-dashbaord') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                    },
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'svcnumber',
                        name: 'svcnumber'
                    },
                    {
                        data: 'rank_name',
                        name: 'rank_name'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'return_date',
                        name: 'return_date'
                    },
                    {
                        data: 'return_status',
                        name: 'return_status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            function setDateRange(startDate, endDate) {
                $('#startDate').val(startDate);
                $('#endDate').val(endDate);
                dataTable.draw();
            }

            $('#filter-today').on('click', function() {
                var today = new Date().toISOString().split('T')[0];
                setDateRange(today, today);
            });

            $('#filter-week').on('click', function() {
                var today = new Date();
                var startOfWeek = today;
                var endOfWeek = new Date(today);
                endOfWeek.setDate(today.getDate() + 6); // Set end date to today + 6 days
                setDateRange(startOfWeek.toISOString().split('T')[0], endOfWeek.toISOString().split('T')[
                    0]);
            });

            $('#filter-month').on('click', function() {
                var today = new Date();
                var startOfMonth = new Date(today.getFullYear(), today.getMonth(), today
                    .getDate()); // Start from today
                var endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate() -
                    1); // End on the same date next month
                setDateRange(startOfMonth.toISOString().split('T')[0], endOfMonth.toISOString().split('T')[
                    0]);
            });

            $('#filter-range').on('click', function() {
                setDateRange($('#startDatePicker').val(), $('#endDatePicker').val());
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function updateTime() {
                var now = new Date();
                var date = now.getDate();
                var month = now.toLocaleString('default', {
                    month: 'long'
                });
                var year = now.getFullYear();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var seconds = now.getSeconds();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // Handle midnight
                minutes = pad(minutes);
                seconds = pad(seconds);
                var currentTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

                var currentDate = date + ' ' + month + ' ' + year;
                $("#current-date-time").text("OVERVIEW OF TRAVEL DETAILS AS AT " + currentDate + " " + currentTime);
            }
            updateTime(); // Call the function once to display the initial time
            setInterval(updateTime, 1000); // Update the time every second
            // Check if the user is authenticated
            var isAuthenticated = "{{ Auth::check() }}";
            if (isAuthenticated) {
                var systemAccessedTime = sessionStorage.getItem('systemAccessedTime');
                if (!systemAccessedTime) {
                    // If not stored, set it to current time
                    systemAccessedTime = new Date().getTime();
                    sessionStorage.setItem('systemAccessedTime', systemAccessedTime);
                }

                function updateCountdown() {
                    var now = new Date();
                    var timeElapsed = new Date(now - parseInt(systemAccessedTime));
                    var hours = timeElapsed.getUTCHours();
                    var minutes = timeElapsed.getUTCMinutes();
                    var seconds = timeElapsed.getUTCSeconds();
                }
                updateCountdown(); // Call the function once to display the initial time
                var x = setInterval(updateCountdown, 1000); // Update the countdown every second
            }
            // Function to pad single digits with leading zeros
            function pad(num) {
                return (num < 10 ? "0" : "") + num;
            }
        });
    </script>
@endsection
