@extends('admin.admin_master')
@section('title')
    Mech - Civilian
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
        <div class="card">
            <div class="card-header border-0">
                <nav class="navbar justify-content-between p-0 align-items-center">
                    <h5>Add New Travel Details</h5>
                    <div class="input-group" style="width: auto;">
                        <div class="col text-right">
                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <a href="{{ route('create-record') }}" class="btn btn-sm btn-info " aria-haspopup="true"
                                    aria-expanded="false"><i class=""></i>
                                    <h6 style="color: #fff">MILITARY FORM </h6>
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row" style="background-color: #fff; margin:15px 0 15px 0">
            <div class="col-md-2 border-right">

                <div class="d-flex flex-column align-items-center text-center p-3 py-5" style="margin-top: -40px">
                    <img class="rounded-circle mt-5" id="showImage" width="200px" src="{{ url('upload/personnel.jpeg') }}"
                        alt="Card image cap"><span class="font-weight-bold">Personnel Photo</span><span> </span>
                    <form action="{{ route('store-civilian-record') }}" method="POST" id="myForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <input name="personnel_image" class="form-control" type="file" id="image">
                            @error('personnel_image')
                                <span class="btn btn-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>
            </div>
            <div class="col-md-10 border-right">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-body">
                            <h5>
                                CIVILIAN DETAILS
                            </h5>
                            <hr>

                            <div class="row" style="background-color: rgb(241, 245, 240); padding-top:20px">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                            class="col-sm-4 col-form-label col-form-label-sm">Rank</label>
                                        <div class="col-sm-8">
                                            <select name="rank_name" id="rank_name" class="form-control">
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
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-4 col-form-label">Surname</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="surname" name="surname"
                                                placeholder="surname" value="{{ old('surname') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-4 col-form-label">First Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="first_name"
                                                name="first_name"value="{{ old('first_name') }}" placeholder="first name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-4 col-form-label">O/Names</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="othernames"
                                                name="othernames"value="{{ old('othernames') }}" placeholder="othernames">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-4 col-form-label">Gender</label>
                                        <div class="col-sm-8">
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="MALE">MALE</option>
                                                <option value="FEMALE">FEMALE</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-4 col-form-label">Mobile No</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="mobile_no"
                                                name="mobile_no"value="{{ old('mobile_no') }}"
                                                placeholder="eg.0245002022">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-4 col-form-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email') }}" placeholder="email">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <label for="unit" class="col-sm-4 col-form-label">Category</label>
                                        <div class="col-sm-8">
                                            <input name="service_category" class="form-control" type="text"
                                                id="service_category" placeholder="Category" value="CIVILIAN"
                                                value="{{ old('service_category') }}">
                                            @error('service_category')
                                                <span class="btn btn-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist" style="margin-top: 30px">
                                <li class="nav-item">
                                    <a class="nav-link active text-uppercase" id="home-tab" data-toggle="tab"
                                        href="#home" role="tab" aria-controls="home" aria-selected="true">
                                        <h5 style="margin-left: -10px">DEPLOYMENT</h5>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-uppercase" id="history-tab" data-toggle="tab"
                                        href="#history" role="tab" aria-controls="history" aria-selected="false">
                                        <h5>TRAVEL HISTORY</h5>
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
                                        @php
                                            $countries = [
                                                'Afghanistan',
                                                'Albania',
                                                'Algeria',
                                                'Andorra',
                                                'Angola',
                                                'Antigua and Barbuda',
                                                'Argentina',
                                                'Armenia',
                                                'Australia',
                                                'Austria',
                                                'Azerbaijan',
                                                'Bahamas',
                                                'Bahrain',
                                                'Bangladesh',
                                                'Barbados',
                                                'Belarus',
                                                'Belgium',
                                                'Belize',
                                                'Benin',
                                                'Bhutan',
                                                'Bolivia',
                                                'Bosnia and Herzegovina',
                                                'Botswana',
                                                'Brazil',
                                                'Brunei',
                                                'Bulgaria',
                                                'Burkina Faso',
                                                'Burundi',
                                                'Cabo Verde',
                                                'Cambodia',
                                                'Cameroon',
                                                'Canada',
                                                'Central African Republic',
                                                'Chad',
                                                'Chile',
                                                'China',
                                                'Colombia',
                                                'Comoros',
                                                'Congo',
                                                'Costa Rica',
                                                'Croatia',
                                                'Cuba',
                                                'Cyprus',
                                                'Czechia',
                                                "Côte d'Ivoire",
                                                'Denmark',
                                                'Djibouti',
                                                'Dominica',
                                                'Dominican Republic',
                                                'Ecuador',
                                                'Egypt',
                                                'El Salvador',
                                                'Equatorial Guinea',
                                                'Eritrea',
                                                'Estonia',
                                                'Eswatini',
                                                'Ethiopia',
                                                'Fiji',
                                                'Finland',
                                                'France',
                                                'Gabon',
                                                'Gambia',
                                                'Georgia',
                                                'Germany',
                                                'Ghana',
                                                'Greece',
                                                'Grenada',
                                                'Guatemala',
                                                'Guinea',
                                                'Guinea-Bissau',
                                                'Guyana',
                                                'Haiti',
                                                'Honduras',
                                                'Hungary',
                                                'Iceland',
                                                'India',
                                                'Indonesia',
                                                'Iran',
                                                'Iraq',
                                                'Ireland',
                                                'Israel',
                                                'Italy',
                                                'Jamaica',
                                                'Japan',
                                                'Jordan',
                                                'Kazakhstan',
                                                'Kenya',
                                                'Kiribati',
                                                'Kuwait',
                                                'Kyrgyzstan',
                                                'Laos',
                                                'Latvia',
                                                'Lebanon',
                                                'Lesotho',
                                                'Liberia',
                                                'Libya',
                                                'Liechtenstein',
                                                'Lithuania',
                                                'Luxembourg',
                                                'Madagascar',
                                                'Malawi',
                                                'Malaysia',
                                                'Maldives',
                                                'Mali',
                                                'Malta',
                                                'Marshall Islands',
                                                'Mauritania',
                                                'Mauritius',
                                                'Mexico',
                                                'Micronesia',
                                                'Moldova',
                                                'Monaco',
                                                'Mongolia',
                                                'Montenegro',
                                                'Morocco',
                                                'Mozambique',
                                                'Myanmar',
                                                'Namibia',
                                                'Nauru',
                                                'Nepal',
                                                'Netherlands',
                                                'New Zealand',
                                                'Nicaragua',
                                                'Niger',
                                                'Nigeria',
                                                'North Korea',
                                                'North Macedonia',
                                                'Norway',
                                                'Oman',
                                                'Pakistan',
                                                'Palau',
                                                'Palestine',
                                                'Panama',
                                                'Papua New Guinea',
                                                'Paraguay',
                                                'Peru',
                                                'Philippines',
                                                'Poland',
                                                'Portugal',
                                                'Qatar',
                                                'Romania',
                                                'Russia',
                                                'Rwanda',
                                                'Saint Kitts and Nevis',
                                                'Saint Lucia',
                                                'Saint Vincent and the Grenadines',
                                                'Samoa',
                                                'San Marino',
                                                'Sao Tome and Principe',
                                                'Saudi Arabia',
                                                'Senegal',
                                                'Serbia',
                                                'Seychelles',
                                                'Sierra Leone',
                                                'Singapore',
                                                'Slovakia',
                                                'Slovenia',
                                                'Solomon Islands',
                                                'Somalia',
                                                'South Africa',
                                                'South Korea',
                                                'South Sudan',
                                                'Spain',
                                                'Sri Lanka',
                                                'Sudan',
                                                'Suriname',
                                                'Sweden',
                                                'Switzerland',
                                                'Syria',
                                                'Taiwan',
                                                'Tajikistan',
                                                'Tanzania',
                                                'Thailand',
                                                'Timor-Leste',
                                                'Togo',
                                                'Tonga',
                                                'Trinidad and Tobago',
                                                'Tunisia',
                                                'Turkey',
                                                'Turkmenistan',
                                                'Tuvalu',
                                                'Uganda',
                                                'Ukraine',
                                                'United Arab Emirates',
                                                'United Kingdom',
                                                'United States',
                                                'Uruguay',
                                                'Uzbekistan',
                                                'Vanuatu',
                                                'Vatican City',
                                                'Venezuela',
                                                'Vietnam',
                                                'Yemen',
                                                'Zambia',
                                                'Zimbabwe',
                                            ];
                                        @endphp

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
                                                <label for="name" class="col-sm-4 col-form-label"> Destination
                                                    Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="destination_address"
                                                        name="destination_address"
                                                        value="{{ old('destination_address') }}"
                                                        placeholder="Destination Address">
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
                                                <label for="name" class="col-sm-4 col-form-label"> Departure Flight
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
                                                    <input type="text" class="form-control" id="return_flight_number"
                                                        name="return_flight_number"
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
                                                        name="passport_number"value="{{ old('passport_number') }}"
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
                                                    <input type="date" class="form-control my-1"
                                                        id="passport_expiry_date"
                                                        name="passport_expiry_date"value="{{ old('passport_expiry_date') }}"
                                                        placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" id="coyDiv">
                                            <div class="form-group row">
                                                <label for="colFormLabel" class="col-sm-4 col-form-label">Amount</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="amount"
                                                        name="amount" value="{{ old('amount') }}" placeholder="Amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="coyDiv">
                                            <div class="form-group row">
                                                <label for="colFormLabel"
                                                    class="col-sm-4 col-form-label">Sponsorship</label>
                                                <div class="col-sm-8">
                                                    <select name="sponsorship" id="sponsorship" class="form-control">
                                                        <option value=""></option>
                                                        <option value="GAF">GAF</option>
                                                        <option value="SELF-SPONSORSHIP">SELF-SPONSORSHIP</option>
                                                        <option value="ORGANIZATION">ORGANIZATION</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="coyDiv">
                                            <div class="form-group row">
                                                <label for="colFormLabel"
                                                    class="col-sm-4 col-form-label">Responsibility</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="responsibility"
                                                        name="responsibility" value="{{ old('responsibility') }}"
                                                        placeholder="Responsibility">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" id="coyDiv">
                                            <div class="form-group row">
                                                <label for="colFormLabelLg"
                                                    class="col-sm-4 col-form-label ">Remarks</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control"
                                                        name="remarks" value="{{ old('remarks') }}"
                                                        placeholder="remarks">
                                                    @error('remarks')
                                                        <span class="btn btn-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3" hidden>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Today`s date</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="today_date" class="form-control"
                                                        id="todaydatefordeparture" value="{{ date('m/d/Y') }}" readonly>
                                                    @error('today_date')
                                                        <span class="btn btn-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                                    <div class="row align-items-center m-l-0">
                                        <div class="dt-responsive table-responsive">
                                            <table id="main-report" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            No.
                                                        </th>
                                                        <th>#SER</th>
                                                        <th>PERSONNEL NAME</th>
                                                        <th>GENDER</th>
                                                        <th>COUNTRY</th>
                                                        <th>DESTINATION</th>
                                                        <th>DEPARTURE</th>
                                                        <th>ARRIVAL</th>
                                                        <th>FLIGHT NO</th>
                                                        <th>TICKET NO</th>
                                                        <th>PURPOSE</th>
                                                        <th>REMARKS</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <button type="submit" class="btn  btn-primary">Add Record</button>
                                        </div>
                                        <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                            <a href="{{ route('record-manager') }}"
                                                class="btn btn-warning btn-rounded waves-effect waves-light"
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
