@extends('admin.dashboard_master')
@section('admin')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/daterangepicker.css') }}">

    <style>
        .card-body {
            text-decoration-color: rgb(249, 249, 249);
        }

        th,
        td {
            padding: 3px;
        }

        .AutoScroll {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: auto;
            scroll-behavior: smooth;
            animation: autoscroll 20s linear infinite;
        }

        @keyframes autoscroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
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
            background-color: navy;
        }

        tr:hover {
            background-color: #ccc;
        }

        tr[data-href] {

            cursor: pointer;
        }

        thead {}

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
                <div class="card card-border-c-yellow">
                    <div class="card-body" style="">
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
                <div class="card card-border-c-blue">
                    <div class="card-body" style="">
                        <div class="row align-items-center m-l-0">
                            <div class="col-auto">
                                <i class="fas fa-plane-departure f-36 text-c-blue"></i>
                            </div>
                            <div class="col-auto">
                                <h5 style="color:#0722f5">PENDING DEPARTURE</h5>
                                <h2 style="color:#0722f5">{{ $dependings }}</h2>
                            </div>
                        </div>

                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-md-6">
            <div class="card card-border-c-green">
                <div class="card-body" style=""><a href="{{ route('approve-arrival-returns') }}">
                        <div class="row align-items-center m-l-0">
                            <div class="col-auto">
                                <i class="fas fa-plane-arrival f-36 text-c-green"></i>
                            </div>
                            <div class="col-auto">
                                <h5 style="color:rgb(115, 185, 44)">PENDING ARRIVAL</h5>
                                <h2 style="color:rgb(115, 185, 44)">{{ $departures }}</h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="card card-border-c-red">
                <div class="card-body"><a href="{{ route('personnel-returns') }}">
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
            <div class="card card-border-c-black">
                <div class="card-body">
                    <h6 class="" style="text-align: center">ACTIVITY PERIOD</h6>
                    <div class="row align-items-center m-l-0">
                        <div class="col-auto">
                            <div class="col-xl-6 col-md-6 mb-2">
                                <form id="filter-form" method="POST"
                                    action="{{ route('report-filter-base-on-monthly-weekly-daily') }}">
                                    @csrf
                                    <div class="btn-group mb-2" role="group" aria-label="button groups">
                                        <button type="button" class="btn btn-secondary" id="filter-today">TODAY</button>
                                        <button type="button" class="btn btn-secondary" id="filter-week">WEEK</button>
                                        <button type="button" class="btn btn-secondary" id="filter-month">MONTH</button>
                                        <button>
                                            <a href="{{ route('admin.index') }}" class=""><i
                                                    class="feather icon-home"></i>HOME</a>
                                        </button>
                                        <div class="col-sm-7">
                                            <input type="text" name="datefilter" value="" class="form-control"
                                                placeholder="Select Date Range">
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body py-2 text-center">
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
                                <th>FULL NAME</th>
                                <th>CONTACT</th>
                                <th>COUNTRY</th>
                                {{-- <th>DESTINATION</th> --}}
                                <th>DEPARTURE</th>
                                <th>D/FLT</th>
                                <th>ARRIVAL</th>
                                <th>A/FLT</th>
                                <th>STATUS</th>
                                {{-- <th>STATE</th> --}}
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


    <script type="text/javascript">
        $(function() {

            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format(
                    'MM/DD/YYYY'));
            });

            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            function autoScroll() {
                var scrollSpeed = 50;
                var scrollAmount = 2;
                var table = document.getElementById("travel-grid");
                var wrapper = table.parentElement;

                if (wrapper.scrollHeight > wrapper.clientHeight) {
                    wrapper.scrollTop += scrollAmount;
                    if (wrapper.scrollTop >= (wrapper.scrollHeight / 2)) {
                        wrapper.scrollTop = 0;
                    }
                }
            }

            function cloneTableRows() {
                var table = $('#travel-grid');
                var tbody = table.find('tbody');
                var rows = tbody.children();
                rows.clone().appendTo(tbody);
            }

            setInterval(autoScroll, 100);

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
                        data: 'full_name',
                        name: 'full_name'
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
                    },
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
                initComplete: function() {
                    cloneTableRows();
                }
            });

            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('-');
            }

            $('#filter-today').on('click', function() {
                var today = new Date();
                $('#startDate').val(formatDate(today));
                $('#endDate').val(formatDate(today));
                table.ajax.reload();
            });

            $('#filter-week').on('click', function() {
                var today = new Date();
                var nextWeek = new Date();
                nextWeek.setDate(today.getDate() + 6);
                $('#startDate').val(formatDate(today));
                $('#endDate').val(formatDate(nextWeek));
                table.ajax.reload();
            });

            $('#filter-month').on('click', function() {
                var today = new Date();
                var nextMonth = new Date();
                nextMonth.setMonth(today.getMonth() + 1);
                nextMonth.setDate(today.getDate() - 1);
                $('#startDate').val(formatDate(today));
                $('#endDate').val(formatDate(nextMonth));
                table.ajax.reload();
            });

            $('#filter-range').on('click', function() {
                var startDate = $('#startDatePicker').val();
                var endDate = $('#endDatePicker').val();
                $('#startDate').val(startDate);
                $('#endDate').val(endDate);
                table.ajax.reload();
            });
        });



        // $(document).ready(function() {
        //     function autoScroll() {
        //         var scrollSpeed = 50; // Adjust scroll speed as needed
        //         var scrollAmount = 2; // Adjust scroll amount as needed
        //         var table = document.getElementById("travel-grid");
        //         var wrapper = table.parentElement;

        //         // Check if the scrollable height is greater than the wrapper height
        //         if (wrapper.scrollHeight > wrapper.clientHeight) {
        //             wrapper.scrollTop += scrollAmount;
        //             // Reset scroll position when the bottom of the original content is reached
        //             if (wrapper.scrollTop >= (wrapper.scrollHeight / 2)) {
        //                 wrapper.scrollTop = 0; // Reset to the top of the original content
        //             }
        //         }
        //     }

        //     // Clone table rows to create a seamless loop
        //     function cloneTableRows() {
        //         var table = $('#travel-grid');
        //         var tbody = table.find('tbody');
        //         var rows = tbody.children();
        //         rows.clone().appendTo(tbody); // Clone and append rows to create a loop
        //     }

        //     // Call autoScroll function every 100 milliseconds
        //     setInterval(autoScroll, 100);

        //     $('#travel-grid').DataTable({
        //         displayLength: 25,
        //         dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
        //             "<'row'<'col-sm-12'tr>>" +
        //             "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        //         buttons: [],
        //         scrollY: "700px",
        //         scrollCollapse: true,
        //         processing: true,
        //         serverSide: true,
        //         lengthMenu: [
        //             [15, 25, 50, 100, 200, -1],
        //             [15, 25, 50, 100, 200, 'All'],
        //         ],
        //         ajax: {
        //             url: "{{ route('api-mission-record') }}",
        //             type: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             data: function(d) {
        //                 var formData = $('#filter-form').serializeArray();
        //                 $.each(formData, function(index, item) {
        //                     d[item.name] = item.value;
        //                 });
        //             },
        //         },
        //         columns: [{
        //                 data: null,
        //                 orderable: false,
        //                 searchable: false,
        //                 render: function(data, type, full, meta) {
        //                     return meta.row + 1;
        //                 }
        //             },
        //             {
        //                 data: 'rank_name',
        //                 name: 'rank_name'
        //             },
        //             {
        //                 data: 'full_name',
        //                 name: 'full_name'
        //             },
        //             {
        //                 data: 'mobile_no',
        //                 name: 'mobile_no'
        //             },
        //             {
        //                 data: 'country',
        //                 name: 'country'
        //             },
        //             {
        //                 data: 'departure_date',
        //                 name: 'departure_date'
        //             },
        //             {
        //                 data: 'departure_flight_number',
        //                 name: 'departure_flight_number'
        //             },
        //             {
        //                 data: 'return_date',
        //                 name: 'return_date'
        //             },
        //             {
        //                 data: 'return_flight_number',
        //                 name: 'return_flight_number'
        //             },
        //             {
        //                 data: 'status',
        //                 name: 'status'
        //             },
        //         ],
        //         rowCallback: function(row, data) {
        //             var warningRanks = [
        //                 'BRIG GEN', 'MAJ GEN', 'LT GEN', 'GEN',
        //                 'R/ADM', 'V/ADMADM', 'AIR CDRE', 'AVM',
        //                 'VM', 'CDRE'
        //             ];
        //             var greenRanks = ['COL', 'CAPT(GN)', 'GP CAPT'];
        //             if (warningRanks.includes(data.rank_name)) {
        //                 $(row).css('background-color', '#ffc107');
        //             }
        //             if (greenRanks.includes(data.rank_name)) {
        //                 $(row).css('background-color', '#28a745');
        //             }
        //         },


        //         initComplete: function() {
        //             cloneTableRows(); // Clone rows after table initialization and data loading
        //         }
        //     });
        // });

        // $(document).ready(function() {
        //     // Helper function to format date to YYYY-MM-DD
        //     function formatDate(date) {
        //         var d = new Date(date),
        //             month = '' + (d.getMonth() + 1),
        //             day = '' + d.getDate(),
        //             year = d.getFullYear();

        //         if (month.length < 2) month = '0' + month;
        //         if (day.length < 2) day = '0' + day;

        //         return [year, month, day].join('-');
        //     }

        //     // Event listeners for filter buttons
        //     $('#filter-today').on('click', function() {
        //         var today = new Date();
        //         $('#startDate').val(formatDate(today));
        //         $('#endDate').val(formatDate(today));
        //         $('#filter-form').submit();
        //     });

        //     $('#filter-week').on('click', function() {
        //         var today = new Date();
        //         var nextWeek = new Date();
        //         nextWeek.setDate(today.getDate() +
        //         6); // Set the end date to 7 days from today (including today)
        //         $('#startDate').val(formatDate(today));
        //         $('#endDate').val(formatDate(nextWeek));
        //         $('#filter-form').submit();
        //     });

        //     $('#filter-month').on('click', function() {
        //         var today = new Date();
        //         var nextMonth = new Date();
        //         nextMonth.setMonth(today.getMonth() + 1);
        //         nextMonth.setDate(today.getDate() -
        //         1); // Subtract one day to get the end of the month period
        //         $('#startDate').val(formatDate(today));
        //         $('#endDate').val(formatDate(nextMonth));
        //         $('#filter-form').submit();
        //     });
        // });

        // $(document).ready(function() {
        //     function autoScroll() {
        //         var scrollSpeed = 50; // Adjust scroll speed as needed
        //         var scrollAmount = 2; // Adjust scroll amount as needed
        //         var table = document.getElementById("travel-grid");
        //         var wrapper = table.parentElement;

        //         // Check if the number of rows exceeds a threshold (e.g., 20 rows)
        //         if (table.rows.length > 20) {
        //             wrapper.scrollTop += scrollAmount;
        //             if (wrapper.scrollTop >= (wrapper.scrollHeight - wrapper.clientHeight)) {
        //                 wrapper.scrollTop = 0;
        //             }
        //         }
        //     }

        //     // Call autoScroll function every 50 milliseconds
        //     setInterval(autoScroll, 100);

        //     $('#travel-grid').DataTable({
        //         displayLength: 25,
        //         dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
        //             "<'row'<'col-sm-12'tr>>" +
        //             "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        //         buttons: [],
        //         scrollY: "600px",
        //         scrollCollapse: true,
        //         processing: true,
        //         serverSide: true,
        //         lengthMenu: [
        //             [15, 25, 50, 100, 200, -1],
        //             [15, 25, 50, 100, 200, 'All'],
        //         ],
        //         ajax: {
        //             url: "{{ route('api-mission-record') }}",
        //             type: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             data: function(d) {
        //                 var formData = $('#filter-form').serializeArray();
        //                 $.each(formData, function(index, item) {
        //                     d[item.name] = item.value;
        //                 });
        //             },
        //         },
        //         columns: [{
        //                 data: null,
        //                 orderable: false,
        //                 searchable: false,
        //                 render: function(data, type, full, meta) {
        //                     return meta.row + 1;
        //                 }
        //             },
        //             {
        //                 data: 'rank_name',
        //                 name: 'rank_name'
        //             },
        //             {
        //                 data: 'full_name',
        //                 name: 'full_name'
        //             },
        //             {
        //                 data: 'mobile_no',
        //                 name: 'mobile_no'
        //             },
        //             {
        //                 data: 'country',
        //                 name: 'country'
        //             },
        //             {
        //                 data: 'departure_date',
        //                 name: 'departure_date'
        //             },
        //             {
        //                 data: 'departure_flight_number',
        //                 name: 'departure_flight_number'
        //             },
        //             {
        //                 data: 'return_date',
        //                 name: 'return_date'
        //             },
        //             {
        //                 data: 'return_flight_number',
        //                 name: 'return_flight_number'
        //             },
        //             {
        //                 data: 'status',
        //                 name: 'status'
        //             },
        //         ],
        //         rowCallback: function(row, data) {
        //             var warningRanks = [
        //                 'BRIG GEN', 'MAJ GEN', 'LT GEN', 'GEN',
        //                 'R/ADM', 'V/ADMADM', 'AIR CDRE', 'AVM',
        //                 'VM', 'CDRE'
        //             ];
        //             var greenRanks = ['COL', 'CAPT(GN)', 'GP CAPT'];
        //             if (warningRanks.includes(data.rank_name)) {
        //                 $(row).css('background-color', '#ffc107');
        //             }
        //             if (greenRanks.includes(data.rank_name)) {
        //                 $(row).css('background-color', '#28a745');
        //             }
        //         }
        //     });
        // });

        // $(document).ready(function() {
        //     function autoScroll() {
        //         var scrollSpeed = 50; // Adjust scroll speed as needed
        //         var scrollAmount = 2; // Adjust scroll amount as needed
        //         var table = document.getElementById("travel-grid");
        //         var wrapper = table.parentElement;
        //         // Check if the number of rows exceeds a threshold (e.g., 20 rows)
        //         if (table.rows.length > 20) {
        //             wrapper.scrollTop += scrollAmount;
        //             if (wrapper.scrollTop == (table.scrollHeight - wrapper.offsetHeight)) {
        //                 wrapper.scrollTop = 0;
        //             }
        //         }
        //     }
        //     // Call autoScroll function every 50 milliseconds
        //     setInterval(autoScroll, 100);
        //     $('#travel-grid').DataTable({
        //         displayLength: 25,
        //         dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
        //             "<'row'<'col-sm-12'tr>>" +
        //             "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        //         buttons: [],
        //         scrollY: "600px",
        //         scrollCollapse: true,
        //         processing: true,
        //         serverSide: true,
        //         lengthMenu: [
        //             [15, 25, 50, 100, 200, -1],
        //             [15, 25, 50, 100, 200, 'All'],
        //         ],
        //         ajax: {
        //             url: "{{ route('api-mission-record') }}",
        //             type: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             data: function(d) {
        //                 var formData = $('#filter-form').serializeArray();
        //                 $.each(formData, function(index, item) {
        //                     d[item.name] = item.value;
        //                 });
        //             },
        //         },
        //         columns: [{
        //                 data: null,
        //                 orderable: false,
        //                 searchable: false,
        //                 render: function(data, type, full, meta) {
        //                     return meta.row + 1;
        //                 }
        //             },
        //             {
        //                 data: 'rank_name',
        //                 name: 'rank_name'
        //             },
        //             {
        //                 data: 'full_name',
        //                 name: 'full_name'
        //             },
        //             {
        //                 data: 'mobile_no',
        //                 name: 'mobile_no'
        //             },
        //             {
        //                 data: 'country',
        //                 name: 'country'
        //             },
        //             {
        //                 data: 'departure_date',
        //                 name: 'departure_date'
        //             },
        //             {
        //                 data: 'departure_flight_number',
        //                 name: 'departure_flight_number'
        //             },
        //             {
        //                 data: 'return_date',
        //                 name: 'return_date'
        //             },
        //             {
        //                 data: 'return_flight_number',
        //                 name: 'return_flight_number'
        //             },
        //             {
        //                 data: 'status',
        //                 name: 'status'
        //             },
        //         ],
        //         rowCallback: function(row, data) {
        //             var warningRanks = [
        //                 'BRIG GEN', 'MAJ GEN', 'LT GEN', 'GEN',
        //                 'R/ADM', 'V/ADMADM', 'AIR CDRE', 'AVM',
        //                 'VM', 'CDRE'
        //             ];
        //             var greenRanks = ['COL', 'CAPT(GN)', 'GP CAPT'];
        //             if (warningRanks.includes(data.rank_name)) {
        //                 $(row).css('background-color', '#ffc107');
        //             }
        //             if (greenRanks.includes(data.rank_name)) {
        //                 $(row).css('background-color', '#28a745');
        //             }
        //         }
        //     });
        // });
    </script>


    {{-- <script>
        $(document).ready(function() {
            function autoScroll() {
                var scrollSpeed = 50; // Adjust scroll speed as needed
                var scrollAmount = 2; // Adjust scroll amount as needed
                var table = document.getElementById("travel-grid");
                var wrapper = table.parentElement;
                // Check if the number of rows exceeds a threshold (e.g., 20 rows)
                if (table.rows.length > 20) {
                    wrapper.scrollTop += scrollAmount;
                    if (wrapper.scrollTop == (table.scrollHeight - wrapper.offsetHeight)) {
                        wrapper.scrollTop = 0;
                    }
                }
            }
            // Call autoScroll function every 50 milliseconds
            setInterval(autoScroll, 100);

            $('#travel-grid').DataTable({
                // paging: false,
                displayLength: 25,
                dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                buttons: [
                    // 'colvis',
                    // {
                    //     extend: 'copy',
                    //     text: 'Copy to clipboard'
                    // },
                    // 'excel',
                ],
                scrollY: "700px",
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: "{{ route('api-mission-record') }}",
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
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'mobile_no',
                        name: 'mobile_no'
                    },
                    {
                        data: 'country',
                        name: 'country',
                    },
                    // {
                    //     data: 'destination_address',
                    //     name: 'destination_address'
                    // },
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
                    },
                    // {
                    //     data: 'state',
                    //     name: 'state'
                    // },
                ],
            });
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
