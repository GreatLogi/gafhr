@extends('admin.dashboard_master')
@section('title')
    DASHBOARD
@endsection
@section('admin')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/daterangepicker.css') }}">
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
                <div class="p-2 card-body d-flex flex-column justify-content-center">
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
                                <div class="mb-2 d-flex justify-content-between">
                                    <div class="btn-group" role="group" aria-label="button groups">
                                        <button type="button" class="btn btn-secondary" id="filter-today">TODAY</button>
                                        <button type="button" class="btn btn-secondary" id="filter-week">WEEK</button>
                                        <button type="button" class="btn btn-secondary" id="filter-month">MONTH</button>
                                    </div>
                                </div>
                                <div class="mb-1 d-flex align-items-center">
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
        <div class="py-2 text-center card-body">
            <h4 id="current-date-time" style="color: #0d187d"></h4>

            <div class="marquee" style="color: red;">
                <marquee style="color: red;">
                    @foreach ($records as $record)
                        @if ($record['status'] == 1)
                            @if ($record['days_to_departure'] > 0)
                                {{ $record['rank_name'] }} {{ $record['surname'] }} {{ $record['first_name'] }}
                                {{ $record['othernames'] }} - {{ $record['days_to_departure'] }} DAYS TO DEPARTURE |
                            @else
                                {{ $record['rank_name'] }} {{ $record['surname'] }} {{ $record['first_name'] }}
                                {{ $record['othernames'] }} - {{ abs($record['days_to_departure']) }} DAYS PASSED SINCE
                                DEPARTURE|
                            @endif
                        @elseif ($record['status'] == 2)
                            @if ($record['days_to_return'] > 0)
                                {{ $record['rank_name'] }} {{ $record['surname'] }} {{ $record['first_name'] }}
                                {{ $record['othernames'] }} - {{ $record['days_to_return'] }} DAYS LEFT TO RETURN |
                            @else
                                {{ $record['rank_name'] }} {{ $record['surname'] }} {{ $record['first_name'] }}
                                {{ $record['othernames'] }} - {{ abs($record['days_to_return']) }} DAYS PASSED SINCE
                                RETURN |
                            @endif
                        @endif
                    @endforeach
                </marquee>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center m-l-0">
                <div class="dt-responsive table-responsive" id="id">
                    <table id="travel-grid" class="table-striped table-responsive-stack">
                        <thead style="position: -webkit-sticky; width: 100%; top:0; background-color: navy;">
                            <tr style="color:#FFF111; background-color: navy;">
                                <th>No.</th>
                                <th>RANK/TITLE</th>
                                <th>PERSONAL</th>
                                <th>CONTACT</th>
                                <th>COUNTRY</th>
                                <th>DEPARTURE</th>
                                <th>D/FLT</th>
                                <th>ARRIVAL</th>
                                <th>A/FLT</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ac-datepicker.js') }}"></script>
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
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        function reloadTable() {
            $('#travel-grid').DataTable().ajax.reload();
        }

        // ---- FILTER BUTTONS ----
        $('#filter-today').on('click', function() {
            var today = new Date();
            var formattedDate = formatDate(today);
            $('#startDate').val(formattedDate);
            $('#endDate').val(formattedDate);
            $('#startDatePicker').val(formattedDate);
            $('#endDatePicker').val(formattedDate);
            reloadTable();
        });

        $('#filter-week').on('click', function() {
            var today = new Date();
            var nextWeek = new Date();
            nextWeek.setDate(today.getDate() + 6);
            $('#startDate').val(formatDate(today));
            $('#endDate').val(formatDate(nextWeek));
            $('#startDatePicker').val(formatDate(today));
            $('#endDatePicker').val(formatDate(nextWeek));
            reloadTable();
        });

        $('#filter-month').on('click', function() {
            var today = new Date();
            var nextMonth = new Date();
            nextMonth.setMonth(today.getMonth() + 1);
            nextMonth.setDate(today.getDate() - 1);
            $('#startDate').val(formatDate(today));
            $('#endDate').val(formatDate(nextMonth));
            $('#startDatePicker').val(formatDate(today));
            $('#endDatePicker').val(formatDate(nextMonth));
            reloadTable();
        });

        $('#filter-range').on('click', function() {
            var startDate = $('#startDatePicker').val();
            var endDate = $('#endDatePicker').val();
            if (startDate && endDate) {
                $('#startDate').val(startDate);
                $('#endDate').val(endDate);
                reloadTable();
            } else {
                alert('Please select a start date and end date.');
            }
        });

        // ---- DATATABLE ----
        var table = $('#travel-grid').DataTable({
            displayLength: 25,
            dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            buttons: [],
            scrollY: "100%",       // use 100% height instead of fixed px
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            lengthMenu: [
                [15, 25, 50, 100, 200, -1],
                [15, 25, 50, 100, 200, 'All'],
            ],
            ajax: {
                url: "{{ route('report-filter-base-on-monthly-weekly-daily') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    var formData = $('#filter-form').serializeArray();
                    $.each(formData, function(index, item) {
                        d[item.name] = item.value;
                    });
                },
            },
            columns: [
                { data: null, orderable: false, searchable: false, render: function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                { data: 'rank_name', name: 'rank_name' },
                { data: 'initial', name: 'initial' },
                { data: 'mobile_no', name: 'mobile_no' },
                { data: 'country', name: 'country' },
                { data: 'departure_date', name: 'departure_date' },
                { data: 'departure_flight_number', name: 'departure_flight_number' },
                { data: 'return_date', name: 'return_date' },
                { data: 'return_flight_number', name: 'return_flight_number' },
                { data: 'status', name: 'status' }
            ],
            rowCallback: function(row, data) {
                var warningRanks = ['BRIG GEN', 'MAJ GEN', 'LT GEN', 'GEN', 'R/ADM', 'V/ADMADM','AIR CDRE', 'AVM', 'VM', 'CDRE'];
                var greenRanks = ['COL', 'CAPT(GN)', 'GP CAPT'];

                if (warningRanks.includes(data.rank_name)) {
                    $(row).css('background-color', '#ffc107');
                }
                if (greenRanks.includes(data.rank_name)) {
                    $(row).css('background-color', '#28a745');
                }
            }
        });

        // ---- AUTO SCROLL ----
        function autoScroll() {
            var scrollAmount = 1; // pixels per tick
            var wrapper = $('#travel-grid').parent();

            wrapper.scrollTop(wrapper.scrollTop() + scrollAmount);

            if (wrapper.scrollTop() >= (wrapper.prop('scrollHeight') - wrapper.innerHeight())) {
                wrapper.scrollTop(0);
            }
        }

        setInterval(autoScroll, 100);
    });
</script>


    {{-- <script>
        $(document).ready(function() {
            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('-');
            }

            function reloadTable() {
                $('#travel-grid').DataTable().ajax.reload();
            }

            $('#filter-today').on('click', function() {
                var today = new Date();
                var formattedDate = formatDate(today);
                $('#startDate').val(formattedDate);
                $('#endDate').val(formattedDate);
                $('#startDatePicker').val(formattedDate);
                $('#endDatePicker').val(formattedDate);
                reloadTable();
            });

            $('#filter-week').on('click', function() {
                var today = new Date();
                var nextWeek = new Date();
                nextWeek.setDate(today.getDate() + 6);
                var startDate = formatDate(today);
                var endDate = formatDate(nextWeek);
                $('#startDate').val(startDate);
                $('#endDate').val(endDate);
                $('#startDatePicker').val(startDate);
                $('#endDatePicker').val(endDate);
                reloadTable();
            });

            $('#filter-month').on('click', function() {
                var today = new Date();
                var nextMonth = new Date();
                nextMonth.setMonth(today.getMonth() + 1);
                nextMonth.setDate(today.getDate() - 1);
                var startDate = formatDate(today);
                var endDate = formatDate(nextMonth);
                $('#startDate').val(startDate);
                $('#endDate').val(endDate);
                $('#startDatePicker').val(startDate);
                $('#endDatePicker').val(endDate);
                reloadTable();
            });

            $('#filter-range').on('click', function() {
                var startDate = $('#startDatePicker').val();
                var endDate = $('#endDatePicker').val();
                if (startDate && endDate) {
                    $('#startDate').val(startDate);
                    $('#endDate').val(endDate);
                    reloadTable();
                } else {
                    alert('Please select a start date and end date.');
                }
            });

            var table = $('#travel-grid').DataTable({
                displayLength: 25,
                dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                buttons: [],
                scrollY: "700px",
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: "{{ route('report-filter-base-on-monthly-weekly-daily') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        var formData = $('#filter-form').serializeArray();
                        $.each(formData, function(index, item) {
                            d[item.name] = item.value;
                        });
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
                        data: 'rank_name',
                        name: 'rank_name'
                    },
                    {
                        data: 'initial',
                        name: 'initial'
                    },
                    {
                        data: 'mobile_no',
                        name: 'mobile_no'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'departure_date',
                        name: 'departure_date'
                    },
                    {
                        data: 'departure_flight_number',
                        name: 'departure_flight_number'
                    },
                    {
                        data: 'return_date',
                        name: 'return_date'
                    },
                    {
                        data: 'return_flight_number',
                        name: 'return_flight_number'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ],
                rowCallback: function(row, data) {
                    var warningRanks = ['BRIG GEN', 'MAJ GEN', 'LT GEN', 'GEN', 'R/ADM', 'V/ADMADM',
                        'AIR CDRE', 'AVM', 'VM', 'CDRE'
                    ];
                    var greenRanks = ['COL', 'CAPT(GN)', 'GP CAPT'];
                    if (warningRanks.includes(data.rank_name)) {
                        $(row).css('background-color', '#ffc107');
                    }
                    if (greenRanks.includes(data.rank_name)) {
                        $(row).css('background-color', '#28a745');
                    }
                },
                // initComplete: function() {
                //     cloneTableRows();
                // }
            });
            // function autoScroll() {
            //     var scrollSpeed = 50;
            //     var scrollAmount = 2;
            //     var table = document.getElementById("travel-grid");
            //     var wrapper = table.parentElement;

            //     if (wrapper.scrollHeight > wrapper.clientHeight) {
            //         wrapper.scrollTop += scrollAmount;
            //         if (wrapper.scrollTop >= (wrapper.scrollHeight / 2)) {
            //             wrapper.scrollTop = 0;
            //         }
            //     }
            // }

            // function cloneTableRows() {
            //     var table = $('#travel-grid');
            //     var tbody = table.find('tbody');
            //     var rows = tbody.children();
            //     rows.clone().appendTo(tbody);
            // }

            function autoScroll() {
                var scrollAmount = 1;
                var wrapper = $('#travel-grid').parent();
                var visibleRows = Math.floor(wrapper.height() / $('#travel-grid tbody tr:first').height());
                var totalRows = $('#travel-grid tbody tr').length;

                if (totalRows > visibleRows) {
                    wrapper.scrollTop(wrapper.scrollTop() + scrollAmount);

                    if (wrapper.scrollTop() >= (wrapper.prop('scrollHeight') - wrapper.innerHeight())) {
                        wrapper.scrollTop(0);
                    }
                }
            }

            setInterval(autoScroll, 100);
        });
    </script> --}}


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
            updateTime();
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
                updateCountdown();
                var x = setInterval(updateCountdown, 1000); // Update the countdown every second
            }

            function pad(num) {
                return (num < 10 ? "0" : "") + num;
            }
        });
    </script>
@endsection
