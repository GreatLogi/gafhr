@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        #example {
            font-size: 19px;
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Summary Report ESSMGB</h5>
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
    <div class="card bg-pattern">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"
                        style="text-align:center; margin-top:1px;letter-spacing:1px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                        <img src="{{ asset('assets/images/auth/ESSMGB.png') }}" style="width: 5%;" class="rounded"
                            alt="...">
                        <h3 style="color:rgb(8, 141, 218);">PAST ESSMGB GHANBATT DEPLOYMENT DETAILS</h3>
                        <hr>
                    </div>
                    <div class="card-body" style="padding-top: 10px">

                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('api-filter-essmgb') }}" method="POST" id="filter-form">
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
                                                        <option value="{{ $rank->rank_name }}">{{ $rank->rank_name }}
                                                        </option>
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
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <select class="form-control select2" name="arm_of_service">
                                                    <option value>SELECT ARM OF SERVICE</option>
                                                    <option value="ARMY">ARMY</option>
                                                    <option value="NAVY">NAVY</option>
                                                    <option value="AIRFORCE">AIRFORCE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <select class="form-control select2" name="ghanbatt_name">
                                                    <option value>SELECT GHANBATT</option>
                                                    @foreach ($data->unique('ghanbatt_name') as $ghanbatt)
                                                        {{-- @foreach ($data as $ghanbatt) --}}
                                                        <option value="{{ $ghanbatt->ghanbatt_name }}">
                                                            {{ $ghanbatt->ghanbatt_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <select class="form-control select2" name="gender">
                                                    <option value>SELECT GENDER</option>
                                                    <option value="MALE">MALE</option>
                                                    <option value="FEMALE">FEMALE</option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- <div class="col-sm-6 col-md-3">
                                        <div class="form-group form-focus">
                                            <select class="form-control select2" name="country">
                                                <option value>SELECT COUNTRY</option>
                                                @foreach ($data->unique('country') as $coun)
                                                    <option value="{{ $coun->country }}">{{ $coun->country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <select class="form-control select2" name="unit_name">
                                                    <option value>SELECT UNIT</option>
                                                    {{-- @foreach ($data as $coun) --}}
                                                    @foreach ($data->unique('unit_name') as $unit)
                                                        <option value="{{ $unit->unit_name }}">{{ $unit->unit_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
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
                                        </div>
                                        <div class="col-sm-6 col-md-3">
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
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <select class="form-control select2" name="service_category">
                                                    <option value>SELECT SERVICE CATEGORY</option>
                                                    <option value="OFFICER">OFFICER</option>
                                                    <option value="SOLDIER">SOLDIER</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <select class="form-control select2" name="status">
                                                    <option value>SELECT STATUS</option>
                                                    <option value="2">DEPLOYED</option>
                                                    <option value="5">RETURNED</option>
                                                    <option value="6">REPATRIATED</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <input type="date" class="form-control floating"
                                                    name="departure_date">
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
                                            <button type="sumit" class="btn btn-primary btn-block"> Filter </button>
                                        </div>

                                        <div class="col-sm-6 col-md-3">
                                            <a href="{{ route('travel-dash') }}"
                                                class="btn btn-primary btn-block">Dashboard</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <div class="card support-bar overflow-hidden">
                                    <div class="card-body pb-0">
                                        @php
                                            $latestGhannattCount = \App\Models\GafMissionRecord::where('mission_name', 'ESSMGB')
                                                ->whereIn('status', [5, 6])
                                                ->whereNotNull('ghanbatt_name')
                                                ->where('departure_date', function ($query) {
                                                    $query
                                                        ->selectRaw('MAX(departure_date)')
                                                        ->from('gaf_mission_records')
                                                        ->where('mission_name', 'ESSMGB')
                                                        ->whereIn('status', [5, 6])
                                                        ->whereNotNull('ghanbatt_name');
                                                })
                                                ->count();
                                        @endphp
                                        <h5 class="m-0 text-c-blue">PAST DEPLOYMENT</h5>
                                        <p class="mb-3 mt-3">Total number of Troops contributed .</p>
                                    </div>
                                    <div class="card-footer bg-warning text-white">
                                        <div class="row text-center">
                                            <div class="col">
                                                <h4 class="m-0 text-white">{{ $latestGhannattCount }}</h4>
                                                <span>TOTAL</span>
                                            </div>
                                            <div class="col">
                                                <h4 class="m-0 text-white">
                                                    {{ $EcowasMaleCount = \App\Models\GafMissionRecord::where('gender', 'MALE')->where('mission_name', 'ESSMGB')->whereIn('status', [5, 6])->count() }}
                                                </h4>
                                                <span>MALE</span>
                                            </div>
                                            <div class="col">
                                                <h4 class="m-0 text-white">
                                                    {{ $EcowasFemaleCount = \App\Models\GafMissionRecord::where('gender', 'FEMALE')->where('mission_name', 'ESSMGB')->whereIn('status', [5, 6])->count() }}
                                                </h4>
                                                <span>FEMALE</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card support-bar overflow-hidden">
                                    <div class="card-body pb-0">
                                        @php
                                            $latestGhannattCount = \App\Models\GafMissionRecord::where('mission_name', 'ESSMGB')->where('status', 2)->whereNotNull('ghanbatt_name')->whereDate('departure_date', '<=', now())->count();
                                            // Check if departure date is today
                                            $ECOWASMaleCount = \App\Models\GafMissionRecord::where('gender', 'MALE')->where('mission_name', 'ESSMGB')->where('status', 2)->whereNotNull('ghanbatt_name')->whereDate('departure_date', '<=', now())->latest('departure_date')->count();
                                            // Check if departure date is today
                                            $ECOWASFemaleCount = \App\Models\GafMissionRecord::where('gender', 'FEMALE')->where('mission_name', 'ESSMGB')->where('status', 2)->whereNotNull('ghanbatt_name')->whereDate('departure_date', '<=', now())->latest('departure_date')->count();
                                        @endphp
                                        <h5 class="m-0 text-c-blue">CURRENT DEPLOYMENT</h5>
                                        <p class="mb-3 mt-3 ">Total number of Troops currently deployed.</p>
                                    </div>

                                    <div class="card-footer bg-success text-white">
                                        <div class="row text-center">
                                            <div class="col">
                                                <h4 class="m-0 text-white">{{ $latestGhannattCount }}</h4>
                                                <span>TOTAL</span>
                                            </div>
                                            <div class="col">
                                                <h4 class="m-0 text-white">{{ $ECOWASMaleCount }}</h4>
                                                <span>MALE</span>
                                            </div>
                                            <div class="col">
                                                <h4 class="m-0 text-white">{{ $ECOWASFemaleCount }}</h4>
                                                <span>FEMALE</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card user-profile-list">
                    <div class="card-body">
                        <div class="row align-items-center m-l-0">
                            <div class="col-sm-6 text-left"><br />
                                <p>Perform these Actions on Record.</p>
                            </div>
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
                                <table id="essmgb-report" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>
                                                No.
                                            </th>
                                            <th>#SER</th>
                                            <th>RANK</th>
                                            <th>PERSONNEL</th>
                                            <th>GENDER</th>
                                            <th>APPOINTMENT</th>
                                            <th>MISSION</th>
                                            <th>GHANBATT</th>
                                            <th>CHALK LIST</th>
                                            <th>COUNTRY</th>
                                            <th>DEPARTURE DATE</th>
                                            <th>RETURN DATE</th>
                                            <th>STATUS</th>
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
            var dataTable;
            dataTable = $('#essmgb-report').DataTable({
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
                    url: "{{ route('api-essmgb-report') }}",
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
                        data: 'svcnumber',
                        name: 'svcnumber'
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
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'appointment_name',
                        name: 'appointment_name'
                    },
                    {
                        data: 'mission_name',
                        name: 'mission_name'
                    },
                    {
                        data: 'ghanbatt_name',
                        name: 'ghanbatt_name'
                    },
                    {
                        data: 'chalk_list',
                        name: 'chalk_list'
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
                        data: 'return_date',
                        name: 'return_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ],
            });
            $('#filter-form').submit(function(e) {
                e.preventDefault();
                dataTable.ajax.url("{{ route('api-filter-essmgb') }}").settings()[0].ajax.type = 'POST';
                dataTable.draw();
            });
        });
    </script>
@endsection
