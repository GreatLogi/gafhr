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
                        <h5 class="m-b-10">Summary Report MONUSCO</h5>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"
                    style="text-align:center; margin-top:1px;letter-spacing:1px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                    <img src="{{ asset('assets/images/auth/MONUSCO.jpeg') }}" style="width:6%;" class="rounded"
                        alt="...">
                    <h3 style="color:rgb(8, 141, 218);">PAST MONUSCO GHANBATT DEPLOYMENT DETAILS</h3><hr>
                </div>
                <div class="card-body" style="padding-top: 10px">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('monusco-filter') }}" method="POST">
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
                                                @foreach ($reports->unique('rank_name') as $rank)
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
                                                @foreach ($reports->unique('ghanbatt_name') as $ghanbatt)
                                                    {{-- @foreach ($reports as $ghanbatt) --}}
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
                                                
                                                @foreach ($reports->unique('country') as $coun)
                                                    <option value="{{ $coun->country }}">{{ $coun->country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group form-focus">
                                            <select class="form-control select2" name="unit_name">
                                                <option value>SELECT UNIT</option>
                                                {{-- @foreach ($reports as $coun) --}}
                                                @foreach ($reports->unique('unit_name') as $unit)
                                                    <option value="{{ $unit->unit_name }}">{{ $unit->unit_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group form-focus">
                                            <select class="form-control select2" name="appointment_name">
                                                <option value>SELECT APPOINTMENT</option>

                                                @foreach ($reports->unique('appointment_name') as $appointment)
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
                                                <option value="1">DEPLOYED</option>
                                                <option value="3">RESCHEDULED</option>
                                                <option value="2">CANCELLED</option>
                                                <option value="4">RETURNED</option>
                                                <option value="5">STANBY</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group form-focus">
                                            <input type="date" class="form-control floating" name="departure date">
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
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <div class="card support-bar overflow-hidden">
                                <div class="card-body pb-0">
                                    @php
                                        $latestGhannattCount = \App\Models\GafMissionRecord::where('mission_name', 'MONUSCO')
                                            ->where('status', 4)
                                            ->whereNotNull('ghanbatt_name')
                                            ->where('departure_date', function ($query) {
                                                $query
                                                    ->selectRaw('MAX(departure_date)')
                                                    ->from('gaf_mission_records')
                                                    ->where('mission_name', 'MONUSCO')
                                                    ->where('status', 4)
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
                                                {{ $MonuscoMaleCount = \App\Models\GafMissionRecord::where('gender', 'MALE')->where('mission_name', 'MONUSCO')->where('status', 4)->count() }}
                                            </h4>
                                            <span>MALE</span>
                                        </div>
                                        <div class="col">
                                            <h4 class="m-0 text-white">
                                                {{ $MonuscoFemaleCount = \App\Models\GafMissionRecord::where('gender', 'FEMALE')->where('mission_name', 'MONUSCO')->where('status', 4)->count() }}
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
                                        $latestGhannattCount = \App\Models\GafMissionRecord::where('mission_name', 'MONUSCO')
                                            ->where('status', 1)
                                            ->whereNotNull('ghanbatt_name')
                                            ->where('departure_date', function ($query) {
                                                $query
                                                    ->selectRaw('MAX(departure_date)')
                                                    ->from('gaf_mission_records')
                                                    ->where('mission_name', 'MONUSCO')
                                                    ->where('status', 1)
                                                    ->whereNotNull('ghanbatt_name')
                                                    ->latest('departure_date');
                                            })
                                            ->count();
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
                                            <h4 class="m-0 text-white">
                                                {{ $MonuscoMaleCount = \App\Models\GafMissionRecord::where('gender', 'MALE')->where('mission_name', 'MONUSCO')->where('status', 1)->latest('departure_date')->count() }}
                                            </h4>
                                            <span>MALE</span>
                                        </div>
                                        <div class="col">
                                            <h4 class="m-0 text-white">
                                                {{ $MonuscoFemaleCount = \App\Models\GafMissionRecord::where('gender', 'FEMALE')->where('mission_name', 'MONUSCO')->where('status', 1)->latest('departure_date')->count() }}
                                            </h4>
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
                            <div class="dt-responsive table-responsive">
                                <table id="example" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="select_all"
                                                        value="1" id="contactstable-select-all">
                                                    <label class="custom-control-label" for="contactstable-select-all">
                                                    </label>
                                                </div>
                                            </th>
                                            <th>SVC</th>
                                            <th>RANK</th>
                                            <th>PERSONNEL</th>
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
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($reports as $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>
                                                    <h6 class="table-avatar">
                                                        <a href="{{ route('record.details', $item->uuid) }}"
                                                            style="color: rgb(0, 4, 255);">
                                                            <span>{{ $item->svcnumber }}</span></a>
                                                    </h6>
                                                </td>
                                                <td>
                                                    {{ $item->rank_name }}
                                                </td>
                                                <td>{{ substr($item->initial, 0, 2) . ' ' . substr($item->initial, 2) }}
                                                <td>{{ $item->appointment_name }}</td>
                                                <td>{{ $item->mission_name }}</td>
                                                <td>{{ $item->ghanbatt_name }}</td>
                                                <td>{{ $item->chalk_list }}</td>
                                                <td>{{ $item->country }}</td>
                                                <td> {{ date('d M, Y', strtotime($item->departure_date)) }}</td>
                                                <td>{{ date('d M, Y', strtotime($item->return_date)) }}</td>
                                                <td>
                                                    {{-- @if ($item->status == '5')
                                                        <span class="badge badge-warning mr-1 ">Standby</span>
                                                    @elseif($item->status == '1')
                                                        <span class="badge badge-success mr-1 ">Deployed</span>
                                                    @elseif($item->status == '2')
                                                        <span class="badge badge-danger mr-1 ">Cancelled</span>
                                                    @elseif($item->status == '3')
                                                        <span class="badge badge-info mr-1 ">Rescheduled</span>
                                                    @elseif($item->status == '4')
                                                        <span class="badge badge-secondary mr-1 ">Returned</span>
                                                    @endif --}}
                                                    @if ($item->status == '5')
                                                        <span class="badge badge-warning mr-1">STANDBY</span>
                                                    @elseif($item->status == '1' && now()->toDateString() == date('Y-m-d', strtotime($item->departure_date)))
                                                        <span class="badge badge-success mr-1">DEPLOYED</span>
                                                    @elseif($item->status == '1')
                                                        <span class="badge badge-success mr-1">APPROVED</span>
                                                    @elseif($item->status == '2')
                                                        <span class="badge badge-danger mr-1">CANCELLED</span>
                                                    @elseif($item->status == '3')
                                                        <span class="badge badge-info mr-1">RESCHEDULED</span>
                                                    @elseif($item->status == '4')
                                                        <span class="badge badge-secondary mr-1">RETURNED</span>
                                                    @elseif($item->status == '6')
                                                        <span class="badge badge-secondary mr-1">REPATRIATED</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- liveline-section end -->
    </div>
    </div>
    </div>
@endsection
