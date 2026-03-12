@extends('admin.admin_master')
@section('admin')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dataTables.bootstrap4.min.css') }}">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Main Dashboard</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#!">Items listing</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-pattern">
        <div class="card-body py-5 text-center">
            <div class="row align-items-end">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="filters" class="button-group">
                                <button class="button btn btn-outline-secondary my-1 active" data-filter="*">Show
                                    all</button>
                                <button class="button btn btn-outline-secondary my-1"
                                    data-filter=".operation">Operations</button>
                                <button class="button btn btn-outline-secondary my-1"
                                    data-filter=".logistics">Logistics</button>
                                <button class="button btn btn-outline-secondary my-1"
                                    data-filter=".admin">Administration</button>
                                <button class="button btn btn-outline-secondary my-1" data-filter=".others">Others</button>
                            </div>
                        </div>
                    </div>
                    <div class="grid row">
                        <div class="col-lg-3 col-md-6 element-item operation sponsored " data-category="operation">
                            <div class="card">
                                <a href="{{ route('travel-dash') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/UN 000-01.png') }}"
                                                    alt="" style="width: 20%;float:center;">
                                                <h5 class="m-0 text-bold">Current Missions</h5>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item operation sponsored" data-category="operation">
                            <div class="card">
                                <a href="{{ route('past-mission-dash') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/UN TROOPS-01.png') }}"
                                                    alt="" style="width:35%; float:center;">
                                                <h5 class="m-0 text-bold">Past Missions</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 element-item operation sponsored" data-category="operation">
                            <div class="card">
                                <a href="{{ route('commanders') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/UN commanders-01.png') }}"
                                                    alt="" style="width: 20%;float:center;">
                                                <h5 class="m-0 text-bold " style="text-align: center;">Experts on Mission
                                                </h5>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item admin notrated " data-category="logistics">
                            <a href="{{ route('record-manager') }}">
                                <div class="card">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/folder.png') }}" alt=""
                                                    style="width: 20%;float:center;">
                                                <h5 class="m-0 text-bold">Record Management</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item admin sponsored " data-category="admin">
                            <div class="card">
                                <a href="{{ route('contact-directory') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/telephone-directory.png') }}"
                                                    alt="" style="width: 20%;float:center;">
                                                <h5 class="m-0 text-bold">Contact Directory</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item admin notrated " data-category="admin">
                            <div class="card">
                                <a href="{{ route('female_gender_distribution') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/gender.png') }}"
                                                    alt="" style="width: 20%;float:center;">
                                                <h5 class="m-0 text-bold">Gender Distribution</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item operation neutral " data-category="operation">
                            <div class="card">
                                <a href="{{ route('calender') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/UN 14-000-01.png') }}"
                                                    alt="" style="width: 20%;float:center;">
                                                <h5 class="m-0 text-bold">War Diary</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item logistics medium " data-category="logistics">
                            <div class="card">
                                <a href="{{ route('home.dash') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/UN Armor-01.png') }}"
                                                    alt="" style="width: 28%;float:center;">
                                                <h5 class="m-0 text-bold">Logistics Management</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item admin neutral " data-category="admin">
                            <div class="card">
                                <div class="card-body" style="height: 120px;">
                                    <div class="media align-items-center p-0">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/dashicons/salary.png') }}" alt=""
                                                style="width: 20%;float:center;">
                                            <h5 class="m-0 text-bold">Payroll Manager</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item admin sponsored " data-category="admin">
                            <div class="card">
                                <div class="card-body" style="height: 120px;">
                                    <div class="media align-items-center p-0">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/dashicons/leave.png') }}" alt=""
                                                style="width: 20%;float:center;">
                                            <h5 class="m-0 text-bold">Leave Schedule</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item others medium " data-category="others">
                            <div class="card">
                                <div class="card-body" style="height: 120px;">
                                    <div class="media align-items-center p-0">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/dashicons/ambulance.png') }}"
                                                alt="" style="width: 20%;float:center;">
                                            <h5 class="m-0 text-bold">Medical Matters</h5>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item others neutral " data-category="others">
                            <div class="card">
                                <div class="card-body" style="height: 120px;">
                                    <div class="media align-items-center p-0">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/dashicons/training.png') }}" alt=""
                                                style="width: 20%;float:center;">
                                            <h5 class="m-0 text-bold">Learning Platform</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item others sponsored " data-category="others">
                            <div class="card">
                                <div class="card-body" style="height: 120px;">
                                    <div class="media align-items-center p-0">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/dashicons/care.png') }}" alt=""
                                                style="width: 20%;float:center;">
                                            <h5 class="m-0 text-bold">CIMIC Activities</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item operation sponsored " data-category="operation">
                            <div class="card">
                                <a href="{{ route('mission-pending') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/mail.png') }}" alt=""
                                                    style="width: 18%;float:center;">
                                                <h5 class="m-0 text-bold">Memo System</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 element-item operation sponsored " data-category="operation">
                            <div class="card">
                                <a href="{{ route('mission-pending') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/jeep.png') }}" alt=""
                                                    style="width: 18%;float:center;">
                                                <h5 class="m-0 text-bold">Patrol Plan</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 element-item operation sponsored" data-category="operation">
                            <div class="card">
                                <a href="{{ route('mission-pending') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/map.png') }}" alt=""
                                                    style="width: 18%;float:center;">
                                                <h5 class="m-0 text-bold">Deployment Maps</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 element-item logistics notrated " data-category="admin">
                            <div class="card">
                                <div class="card-body" style="height: 120px;">
                                    <div class="media align-items-center p-0">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/dashicons/point-of-sale.png') }}"
                                                alt="" style="width: 20%;float:center;">
                                            <h5 class="m-0 text-bold" style="float: center;">Post Exchange</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item others notrated " data-category="others">
                            <div class="card">
                                <a href=" {{ route('system-report') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/analysis.png') }}"
                                                    alt="" style="width: 18%;float:center;">
                                                <h5 class="m-0 text-bold">Report Generation</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item admin notrated " data-category="admin">
                            <div class="card">
                                {{-- <a href="{{ route('contact-directory') }}"> --}}
                                <div class="card-body" style="height: 120px;">
                                    <div class="media align-items-center p-0">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/images/dashicons/nomination.png') }}"
                                                alt="" style="width: 20%;float:center;">
                                            <h5 class="m-0 text-bold">Nominations</h5>
                                        </div>
                                    </div>
                                </div>
                                {{-- </a> --}}
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 element-item others notrated " data-category="others">
                            <div class="card">

                                <a href="{{ route('users.index') }}">
                                    <div class="card-body" style="height: 120px;">
                                        <div class="media align-items-center p-0">
                                            <div class="text-center">
                                                <img src="{{ asset('assets/images/dashicons/setting.png') }}"
                                                    alt="" style="width: 18%;float:center;">
                                                <h5 class="m-0 text-bold">User Account Management</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- [ Main Content ] end -->
@endsection
