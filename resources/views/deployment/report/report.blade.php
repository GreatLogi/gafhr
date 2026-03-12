@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">General Report</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">report</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('dashbaord') }}">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header border-0">
                    <nav class="navbar justify-content-between p-0 align-items-center">
                        <h5>GENERAL REPORT GENERATION</h5>
                        <div id="searchResults"></div>
                    </nav>
                </div>
            </div>

            <div class="card user-profile-list">

                <div class="col-md-9 border-right">
                    <div class="card-body">
                        <form action="{{ route('api-filter-report') }}" method="POST" id="filter-form">
                            @csrf
                            <div class="row filter-row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating" name="svcnumber"
                                            placeholder="SERVICE NUMBER">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control" name="rank_name">
                                            <option value>SELECT RANK</option>
                                            @foreach ($data->unique('rank_name') as $rank)
                                                <option value="{{ $rank->rank_name }}">{{ $rank->rank_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating" name="surname"
                                            placeholder="SURNAME">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="text" class="form-control floating" name="first_name"
                                            placeholder="FIRST NAME">
                                    </div>
                                </div>
                            </div>

                            <div class="row filter-row">
                                {{-- <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="arm_of_service">
                                            <option value>SELECT ARM OF SERVICE</option>
                                            <option value="ARMY">ARMY</option>
                                            <option value="NAVY">NAVY</option>
                                            <option value="AIRFORCE">AIRFORCE</option>
                                        </select>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus">
                                    <select class="form-control select2" name="ghanbatt_name">
                                        <option value>SELECT GHANBATT</option>
                                        @foreach ($data->unique('ghanbatt_name') as $ghanbatt)
                                          
                                            <option value="{{ $ghanbatt->ghanbatt_name }}">
                                                {{ $ghanbatt->ghanbatt_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                                {{-- <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus">
                                    <select class="form-control select2" name="mission_name">
                                        <option value>SELECT MISSION</option>
                                      
                                        @foreach ($data->unique('mission_name') as $mission)
                                            <option value="{{ $mission->mission_name }}">{{ $mission->mission_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="gender">
                                            <option value>SELECT GENDER</option>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="country">
                                            <option value>SELECT COUNTRY</option>
                                            @foreach ($data->unique('country') as $coun)
                                                <option value="{{ $coun->country }}">{{ $coun->country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus">
                                    <select class="form-control select2" name="appointment_name">
                                        <option value>SELECT APPOINTMENT</option>

                                        @foreach ($data->unique('appointment_name') as $appointment)
                                            <option value="{{ $appointment->appointment_name }}">
                                                {{ $appointment->appointment_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                                {{-- <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus">
                                    <select class="form-control select2" name="chalk_list">
                                        <option value>SELECT CHALK LIST</option>
                                        <option value="CHALK 1">CHALK 1</option>
                                        <option value="CHALK 2">CHALK 2</option>
                                        <option value="CHALK 3">CHALK 3</option>
                                        <option value="CHALK 4">CHALK 4</option>
                                        <option value="CHALK 5">CHALK 5</option>
                                    </select>
                                </div>
                            </div>
                             --}}
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="service_category">
                                            <option value>SELECT SERVICE CATEGORY</option>
                                            <option value="OFFICER">OFFICER</option>
                                            <option value="SOLDIER">SOLDIER</option>
                                            <option value="CIVILIAN">CIVILIAN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <select class="form-control select2" name="status">
                                            <option value>SELECT STATUS</option>
                                            <option value="2">TRAVELED</option>
                                            <option value="5">RETURNED</option>
                                            <option value="6">REPATRIATED</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="date" class="form-control floating" name="departure_date">
                                        <label class="focus-label">DEPARTURE DATE</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group form-focus">
                                        <input type="date" class="form-control floating" name="return_date">
                                        <label class="focus-label">RETURNED DATE</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <button type="sumit" class="btn btn-primary btn-block"> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="row align-items-center m-l-0">
                        <div class="col-sm-6 text-right"><br />
                        </div>
                        <input type="hidden" name="_token" value="TdknsMaNi6CJpMFbmut9YrGroWXIuiF4uRmYIKx3">
                        <div class="col-sm-6" id="checkbox_actions" style="display:none;">
                            <div class="btn-group mb-2 mr-2">
                                <button type="button" class="btn  btn-info btn-sm" data-toggle="modal"
                                    data-target="#addGroupContactModal" onclick="specify_type('group')">Add To
                                    Group</button>
                            </div>
                        </div>
                        <div class="dt-responsive table-responsive">
                            <table id="main-report-blade" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            No.
                                        </th>
                                        <th>STATUS</th>
                                        <th>#SER</th>
                                        <th>RANK</th>
                                        <th>FULL NAME</th>
                                        <th>GENDER</th>
                                        <th>CONTACT</th>
                                        <th>SERVICE CATEGORY</th>
                                        <th>COUNTRY</th>
                                        <th>MOBILE</th>
                                        <th>EMAIL</th>
                                        <th>D/FLT</th>
                                        <th>DEPARTURE DATE</th>
                                        <th>ARRIVAL DATE</th>
                                        <th>A/FLT</th>
                                        <th>PASSPORT NUMBER</th>
                                        <th>REMARKS</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Required Js -->
    <!-- <script src="{{ asset('assets/js/vendor-all.min.js ') }}"></script>
                                    <script src="{{ asset('assets/js/plugins/bootstrap.min.js ') }}"></script>
                                    <script src="{{ asset('assets/js/ripple.js ') }}"></script>
                                    <script src="{{ asset('assets/js/pcoded.min.js ') }}"></script>
                                    <script src="{{ asset('assets/js/plugins/moment.js') }}"></script>
                                    <script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
                                    <script src="{{ asset('assets/js/plugins/select2.full.min.js') }}"></script>

                                    <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
                                    <script src="{{ asset('assets/js/pages/data-export-custom.js') }}"></script>

                                    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                                    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
                                    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
                                    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
                                    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
                                    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                                    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script> -->
    <script>
        $(document).ready(function() {
            var dataTable;
            dataTable = $('#main-report-blade').DataTable({
                dom: "<'row'<'col-sm-2'l><'col'B><'col-sm-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                buttons: [
                    'colvis',
                    {
                        extend: 'copy',
                        text: 'Copy to clipboard'
                    },
                    'excel',
                ],
                scrollY: 960,
                scrollCollapse: true,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [15, 25, 50, 100, 200, -1],
                    [15, 25, 50, 100, 200, 'All'],
                ],
                ajax: {
                    url: "{{ route('api-main-report') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        console.log('ddddddd:', d)
                        var formData = $('#filter-form').serializeArray();
                        $.each(formData, function(index, item) {
                            d[item.name] = item.value;
                        });
                    },
                },
                rowGroup: {
                    dataSrc: ['svcnumber'],
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
                        data: 'status',
                        name: 'status'
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
                        data: 'mobile_no',
                        name: 'mobile_no'
                    },

                    {
                        data: 'service_category',
                        name: 'service_category'
                    },

                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'mobile_no',
                        name: 'mobile_no'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'departure_flight_number',
                        name: 'departure_flight_number'
                    },

                    {
                        data: 'departure_date',
                        name: 'departure_date'
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
                        data: 'passport_number',
                        name: 'passport_number'
                    },
                    {
                        data: 'remarks',
                        name: 'remarks'
                    },
                ],

            });
            $('#filter-form').submit(function(e) {
                e.preventDefault();
                dataTable.ajax.url("{{ route('api-filter-report') }}").settings()[0].ajax.type = 'POST';
                dataTable.draw();
            });

        });
    </script>
@endsection
