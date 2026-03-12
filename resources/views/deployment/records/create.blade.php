@extends('admin.admin_master')
@section('title')
    Mech
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Records</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Add New</a></li>
                        <li class="breadcrumb-item"><a href="#!">Record</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="col-md-12">
        {{-- <div class="card">
            <div class="border-0 card-header">
                <nav class="p-0 navbar justify-content-between align-items-center">
                    <h5>Add New Travel Details</h5>
                </nav>
            </div>
        </div> --}}

        <div class="card btn-page">
            <div class="card-header">
                <nav class="p-0 navbar justify-content-between align-items-center">
                    <h5>Add New Travel Details</h5>
                </nav>
            </div>
        </div>


        <div class="row" style="background-color: #fff; margin:15px 0 15px 0">
            <div class="col-md-2 border-right">
                <div class="p-3 py-5 text-center d-flex flex-column align-items-center" style="margin-top: -40px">
                    <img id="personnel_photo" class="mt-5 rounded-circle" width="180px"
                        src="{{ asset('upload/personnel.jpeg') }}" alt="Personnel Photo">
                    <span class="font-weight-bold">Personnel Photo</span><span> </span>
                    <br>
                    <div class="col">
                        <form id="searchForm" action="{{ route('fetch-details') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-8" style="text-align:center">
                                    <input type="text" class="form-control" id="svcSearchInput" name="svcNumber"
                                        placeholder="Service Number">
                                </div>
                                <button type="submit" class="btn btn-light btn-sm ">
                                    <h6>Search </h6>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-10 border-right">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5>
                                PERSONNEL DETAILS
                            </h5>
                            <hr>
                            <form action="{{ route('store-record') }}" method="POST" id="myForm">
                                @csrf
                                <div class="row" style="background-color: rgb(241, 245, 240); padding-top:20px">
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Service ID</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="svcnumber_id"
                                                    name="svcnumber" value="{{ old('svcnumber') }}"
                                                    placeholder="Service Number" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabelSm"
                                                class="col-sm-4 col-form-label col-form-label-sm">Rank</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="rank_id" name="rank_name"
                                                    value="{{ old('rank_name') }}" placeholder="Rank" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">Surname</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="surname" name="surname"
                                                    placeholder="surname" value="{{ old('surname') }}"readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">First Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="first_name"
                                                    name="first_name"value="{{ old('first_name') }}"
                                                    placeholder="first name" readonly>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">O/Names</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="othernames"
                                                    name="othernames"value="{{ old('othernames') }}"
                                                    placeholder="othernames" readonly>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">Gender</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="gender" name="gender"
                                                    placeholder="Gender" value="{{ old('gender') }}"readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="inputPassword3" class="col-sm-4 col-form-label">Mobile No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mobile_no"
                                                    name="mobile_no"value="{{ old('mobile_no') }}"
                                                    placeholder="eg.0245002022" readonly>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">Blood Gp</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="blood_group"
                                                    name="blood_group"value="{{ old('blood_group') }}"
                                                    placeholder="Blood Group" readonly>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Unit</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="unit_id"
                                                    name="unit_name" placeholder="Unit"
                                                    value="{{ old('unit_name') }}"readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ old('email') }}" placeholder="email" readonly>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="unit" class="col-sm-4 col-form-label">Category</label>
                                            <div class="col-sm-8">
                                                <input name="service_category" class="form-control" type="text"
                                                    id="service_category" placeholder="Category" readonly
                                                    value="{{ old('service_category') }}">
                                                @error('service_category')
                                                    <span class="btn btn-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-4 col-form-label">Service</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="service_id"
                                                    name="arm_of_service"value="{{ old('arm_of_service') }}"
                                                    placeholder="arm of service" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            
                                <ul class="mb-3 nav nav-tabs" id="myTab" role="tablist" style="margin-top: 30px">
                                    <li class="nav-item">
                                        <a class="nav-link active text-uppercase" id="home-tab" data-toggle="tab"
                                            href="#home" role="tab" aria-controls="home" aria-selected="true">
                                            <h5 style="margin-left: -10px">TRAVEL DETAILS</h5>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        <div class="row courseDetailsContainer">
                                            <div class="col-md-3" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label"> Purpose</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="purpose"
                                                            name="purpose" value="{{ old('purpose') }}"
                                                            placeholder="Purpose">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label"> Country</label>
                                                    <div class="col-sm-8">
                                                        <select name="country" id="country" class="form-control">
                                                            <option value="">SELECT</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country }}">
                                                                    {{ $country }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label"> Ticket
                                                        Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="ticket_number"
                                                            name="ticket_number" value="{{ old('ticket_number') }}"
                                                            placeholder="Ticket Number">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label"> Departure
                                                        Flight
                                                        No</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control"
                                                            id="departure_flight_number" name="departure_flight_number"
                                                            value="{{ old('departure_flight_number') }}"
                                                            placeholder="Departure Flight Number">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label"> Return Flight
                                                        No</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control"
                                                            id="return_flight_number" name="return_flight_number"
                                                            value="{{ old('return_flight_number') }}"
                                                            placeholder="Return Flight Number">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Departure Date</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="departure_date" class="form-control"
                                                            id="demo" value="{{ old('departure_date') }}">
                                                        @error('departure_date')
                                                            <span class="btn btn-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="colFormLabel" class="col-sm-4 col-form-label">Return
                                                        Date</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control" name="return_date"
                                                            id="backdate" value="{{ old('return_date') }}">
                                                        @error('return_date')
                                                            <span class="btn btn-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label"> ETD</label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control" id="etd"
                                                            name="etd" value="{{ old('etd') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label"> ETA</label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control" id="eta"
                                                            name="eta" value="{{ old('eta') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label">Passport</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="passport_number"
                                                            name="passport_number" value="{{ old('passport_number') }}"
                                                            placeholder="Passport Number">
                                                        @error('passport_number')
                                                            <span class="btn btn-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label">P/Expiry</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="my-1 form-control"
                                                            id="passport_expiry_date" name="passport_expiry_date"
                                                            value="{{ old('passport_expiry_date') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" id="coyDiv">
                                                <div class="form-group row">
                                                    <label for="colFormLabel"
                                                        class="col-sm-4 col-form-label">Sponsorship</label>
                                                    <div class="col-sm-8">
                                                        <select name="sponsorship" id="sponsorship" class="form-control">
                                                            <option>Select Sponsorship</option>
                                                            <option value="GHANA ARMY">GHANA ARMY</option>
                                                            <option value="GHANA NAVY">GHANA NAVY</option>
                                                            <option value="GHANA AIRFORCE">GHANA AIRFORCE</option>
                                                            <option value="DCS">DCS</option>
                                                            <option value="SELF-SPONSORSHIP">SELF-SPONSORSHIP</option>
                                                            <option value="ORGANIZATION">ORGANIZATION</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="inputPassword3"
                                                        class="col-sm-4 col-form-label">Status</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control select" name="status">
                                                            <option value>Select</option>
                                                            <option value="0">STANDBY</option>
                                                            <option value="1">APPROVED</option>
                                                            <option value="2">
                                                                TRAVELED
                                                            </option>
                                                            <option value="5">RETURNED
                                                            </option>
                                                        </select>
                                                        @error('status')
                                                            <span class="btn btn-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="destination_address"
                                                        class="col-sm-3 col-form-label">Destination Address</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            id="destination_address" name="destination_address"
                                                            value="{{ old('destination_address') }}"
                                                            placeholder="Destination Address">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="coyDiv">
                                                <div class="form-group row">
                                                    <label for="responsibility"
                                                        class="col-sm-3 col-form-label">Responsibility</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="responsibility"
                                                            name="responsibility" value="{{ old('responsibility') }}"
                                                            placeholder="Responsibility">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="coyDiv">
                                                <div class="form-group row">
                                                    <label for="remarks" class="col-sm-3 col-form-label">Remarks</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="remarks"
                                                            name="remarks" value="{{ old('remarks') }}"
                                                            placeholder="Remarks">
                                                        @error('remarks')
                                                            <span class="btn btn-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" hidden>
                                                <div class="form-group row">
                                                    <label for="unit" class="col-sm-4 col-form-label">Photo</label>
                                                    <div class="col-sm-8">
                                                        <input name="personnel_image" class="form-control" type="text"
                                                            id="personal_image" readonly>
                                                        @error('personnel_image')
                                                            <span class="btn btn-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>x
                                                </div>
                                            </div>

                                            <div class="col-md-3" hidden>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Today`s date</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="today_date" class="form-control"
                                                            id="todaydatefordeparture" value="{{ date('m/d/Y') }}"
                                                            readonly>
                                                        @error('today_date')
                                                            <span class="btn btn-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-5 col-form-label">Are you traveling with a civilian?</label>
                                        <div class="col-sm-7">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="travelled_with_civ"
                                                    id="YES" value="YES">
                                                <label class="form-check-label" for="YES">YES</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="travelled_with_civ"
                                                    id="NO" value="NO" checked>
                                                <label class="form-check-label" for="NO">NO</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Civilian Details Form -->
                                    <div id="civilian_details"
                                        style="display: none; background-color: rgb(241, 245, 240); padding-top:20px">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="rank_name"
                                                        class="col-sm-4 col-form-label col-form-label-sm">CIV-STATUS</label>
                                                    <div class="col-sm-8">
                                                        <select name="civ_state" id="civ_state" class="form-control">
                                                            <option>Select </option>
                                                            <option value="MR">MR</option>
                                                            <option value="MRS">MRS</option>
                                                            <option value="MISS">MISS</option>
                                                            <option value="DR">DR</option>
                                                            <option value="PROF">PROF</option>
                                                            <option value="REV">REV</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="_civ_full_name"
                                                        class="col-sm-4 col-form-label">Fullname</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="civ_full_name"
                                                            name="civ_full_name" placeholder="civ full name"
                                                            value="{{ old('civ_full_name') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="gender" class="col-sm-4 col-form-label">Gender</label>
                                                    <div class="col-sm-8">
                                                        <select name="civ_gender" id="civ_gender" class="form-control">
                                                            <option value="">Gender</option>
                                                            <option value="MALE">MALE</option>
                                                            <option value="FEMALE">FEMALE</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="mobile_no" class="col-sm-4 col-form-label">Mobile
                                                        No</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="civ_mobile_no"
                                                            name="civ_mobile_no" value="{{ old('civ_mobile_no') }}"
                                                            placeholder="eg.0245002022">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" id="civ_email"
                                                            name="civ_email" value="{{ old('civ_email') }}"
                                                            placeholder="civ email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-5">
                                                <button type="submit" class="btn btn-sm btn-info">Add Record</button>

                                                <a href="{{ route('record-manager') }}"
                                                    class="btn btn-sm btn-warning btn-rounded waves-effect waves-light"
                                                    style="float:right;">
                                                    <i class=""> </i> Cancel Action</a>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <script>
        document.addEventListener('DOMContentLoaded', function() {
            const YESRadio = document.getElementById('YES');
            const noRadio = document.getElementById('NO');
            const civilianDetails = document.getElementById('civilian_details');

            YESRadio.addEventListener('change', function() {
                civilianDetails.style.display = 'block';
            });
            noRadio.addEventListener('change', function() {
                civilianDetails.style.display = 'none';
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#searchForm').on('submit', function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();
                // Clear previous search results
                $('#searchResults').html('');
                var svcNumber = $('#svcSearchInput').val();
                $.ajax({
                    url: '{{ route('fetch-details') }}',
                    method: 'POST',
                    data: {
                        svcNumber: svcNumber,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.not_found) {
                            // If personnel not found, display a message indicating that the personnel does not exist
                            $('#searchResults').html(
                                '<div class="alert alert-danger">Personnel not found.</div>'
                            );
                            // Clear the form fields
                            $('#svcnumber_id').val('');
                            $('#rank_id').val('');
                            $('#surname').val('');
                            $('#first_name').val('');
                            $('#othernames').val('');
                            $('#gender').val('');
                            $('#mobile_no').val('');
                            $('#blood_group').val('');
                            $('#unit_id').val('');
                            $('#email').val('');
                            $('#service_category').val('');
                            $('#service_id').val('');
                            $('#personnel_photo').attr('src',
                                '{{ asset('upload/personnel.jpeg') }}');
                        } else {
                            $('#svcnumber_id').val(response.svcnumber);
                            $('#rank_id').val(response.rank_name);
                            $('#surname').val(response.surname);
                            $('#first_name').val(response.first_name);
                            $('#othernames').val(response.othernames);
                            $('#gender').val(response.gender);
                            $('#mobile_no').val(response.mobile_no);
                            $('#blood_group').val(response.blood_group);
                            $('#unit_id').val(response.unit_id);
                            $('#email').val(response.email);
                            $('#service_category').val(response.service_category);
                            $('#service_id').val(response.arm_of_service);
                            $('#personal_image').val(response.personnel_image);
                            // Update the personnel photo if an image is available
                            if (response.personnel_image) {
                                $('#personnel_photo').attr('src', '{{ asset('') }}' +
                                    response.personnel_image);
                            } else {
                                // If no personnel image URL is provided, use the default image URL
                                $('#personnel_photo').attr('src',
                                    '{{ asset('upload/personnel.jpeg') }}');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error
                    }
                });
            });
        });
    </script>



    <script>
        var date = new Date();
        var tdate = date.getDate();
        var month = date.getMonth() + 1;
        if (tdate < 10) {
            tdate = '0' + tdate;
        }
        if (month < 10) {
            month = '0' + month;
        }
        var year = date.getUTCFullYear();
        var minDate = year + "-" + month + "-" + tdate;
        document.getElementById("demo").setAttribute('min', minDate);
    </script>

    <script>
        var date = new Date();
        var tdate = date.getDate();
        var month = date.getMonth() + 1;
        if (tdate < 10) {
            tdate = '0' + tdate;
        }
        if (month < 10) {
            month = '0' + month;
        }
        var year = date.getUTCFullYear();
        var minDate = year + "-" + month + "-" + tdate;
        document.getElementById("backdate").setAttribute('min', minDate);
    </script>

    <script>
        var date = new Date();
        var tdate = date.getDate();
        var month = date.getMonth() + 1;
        if (tdate < 10) {
            tdate = '0' + tdate;
        }
        if (month < 10) {
            month = '0' + month;
        }
        var year = date.getUTCFullYear();
        var minDate = year + "-" + month + "-" + tdate;
        document.getElementById("todaydatefordeparture").setAttribute('min', minDate);
    </script>

    <script>
        var date = new Date();
        var tdate = date.getDate();
        var month = date.getMonth() + 1;
        if (tdate < 10) {
            tdate = '0' + tdate;
        }
        if (month < 10) {
            month = '0' + month;
        }
        var year = date.getUTCFullYear();
        var minDate = year + "-" + month + "-" + tdate;
        document.getElementById("todaydateforreturn").setAttribute('min', minDate);
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
