@extends('admin.admin_master')

@section('title')
    Edit - Person
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
                        <li class="breadcrumb-item"><a href="#!">Edit</a></li>
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
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-0">
                <nav class="navbar justify-content-between p-0 align-items-center">
                    <h5>Update Record Details</h5>
                    <div id="searchResults"></div>
                </nav>
            </div>
        </div>

        <div class="row" style="background-color: #fff; margin:15px 0 15px 0">
            <div class="col-md-2 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5" style="margin-top: -40px">
                    <img class="rounded-circle mt-5" width="150px" id="showImage"
                        src="{{ $record->personnel_image ? asset($record->personnel_image) : asset('upload/personnel.jpeg') }}"
                        alt="Personnel Photo"><span class="font-weight-bold">Personnel Photo</span><span> </span>
                    <br>

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
                            <form action="{{ route('update-civilian-record', $record->uuid) }}" method="POST"
                                id="myForm">
                                @csrf
                                <div class="row" style="background-color: rgb(241, 245, 240); padding-top:20px">
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabelSm"
                                                class="col-sm-4 col-form-label col-form-label-sm">Rank</label>
                                            <div class="col-sm-8">
                                                <select name="rank_name" id="rank_name" class="form-control">
                                                    <option value="MR"
                                                        {{ $record->rank_name == 'MR' ? 'selected' : '' }}>MR</option>
                                                    <option value="MRS"
                                                        {{ $record->rank_name == 'MRS' ? 'selected' : '' }}>MRS</option>
                                                    <option value="MISS"
                                                        {{ $record->rank_name == 'MISS' ? 'selected' : '' }}>MISS</option>
                                                    <option value="DR"
                                                        {{ $record->rank_name == 'DR' ? 'selected' : '' }}>DR</option>
                                                    <option value="PROF"
                                                        {{ $record->rank_name == 'PROF' ? 'selected' : '' }}>PROF</option>
                                                    <option value="REV"
                                                        {{ $record->rank_name == 'REV' ? 'selected' : '' }}>REV</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">Surname</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="surname" name="surname"
                                                    placeholder="surname" value="{{ $record->surname }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">First Name</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="first_name" name="first_name"
                                                    placeholder="first name" value="{{ $record->first_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">O/Names</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="othernames" name="othernames"
                                                    placeholder="othernames" value="{{ $record->othernames }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">Gender</label>
                                            <div class="col-sm-8">
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="MALE"
                                                        {{ $record->gender == 'MALE' ? 'selected' : '' }}>MALE</option>
                                                    <option value="FEMALE"
                                                        {{ $record->gender == 'FEMALE' ? 'selected' : '' }}>FEMALE</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="inputPassword3" class="col-sm-4 col-form-label">Mobile No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mobile_no"
                                                    name="mobile_no" placeholder="eg.0245002022"
                                                    value="{{ $record->mobile_no }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="colFormLabel" class="col-sm-4 col-form-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="email" value="{{ $record->email }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <label for="unit" class="col-sm-4 col-form-label">Category</label>
                                            <div class="col-sm-8">
                                                <input name="service_category" class="form-control" type="text"
                                                    id="service_category" placeholder="Category"
                                                    value="{{ $record->service_category }}">
                                                @error('service_category')
                                                    <span class="btn btn-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="title" style="margin-top: -70px">
                                    <h4 class="mt-5">Deployment Details</h4>
                                    <hr>
                                </div> --}}

                                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist" style="margin-top: 30px;">
                                    <li class="nav-item">
                                        <a class="nav-link active text-uppercase" id="home-tab" data-toggle="tab"
                                            href="#home" role="tab" aria-controls="home" aria-selected="true">
                                            <h5 style="margin-left: -10px;">DEPLOYMENT</h5>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-uppercase" id="history-tab" data-toggle="tab"
                                            href="#history" role="tab" aria-controls="history"
                                            aria-selected="false">
                                            <h5>HISTORY</h5>
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
                                                            name="purpose" value="{{ $record->purpose }}"
                                                            placeholder="Purpose">
                                                    </div>
                                                </div>
                                            </div>

                                            @php
                                                $countries = [
                                                    'AFGHANISTAN',
                                                    'ALBANIA',
                                                    'ALGERIA',
                                                    'ANDORRA',
                                                    'ANGOLA',
                                                    'ANTIGUA AND BARBUDA',
                                                    'ARGENTINA',
                                                    'ARMENIA',
                                                    'AUSTRALIA',
                                                    'AUSTRIA',
                                                    'AZERBAIJAN',
                                                    'BAHAMAS',
                                                    'BAHRAIN',
                                                    'BANGLADESH',
                                                    'BARBADOS',
                                                    'BELARUS',
                                                    'BELGIUM',
                                                    'BELIZE',
                                                    'BENIN',
                                                    'BHUTAN',
                                                    'BOLIVIA',
                                                    'BOSNIA AND HERZEGOVINA',
                                                    'BOTSWANA',
                                                    'BRAZIL',
                                                    'BRUNEI',
                                                    'BULGARIA',
                                                    'BURKINA FASO',
                                                    'BURUNDI',
                                                    'CABO VERDE',
                                                    'CAMBODIA',
                                                    'CAMEROON',
                                                    'CANADA',
                                                    'CENTRAL AFRICAN REPUBLIC',
                                                    'CHAD',
                                                    'CHILE',
                                                    'CHINA',
                                                    'COLOMBIA',
                                                    'COMOROS',
                                                    'CONGO',
                                                    'COSTA RICA',
                                                    'CROATIA',
                                                    'CUBA',
                                                    'CYPRUS',
                                                    'CZECHIA',
                                                    "CÔTE D'IVOIRE",
                                                    'DENMARK',
                                                    'DJIBOUTI',
                                                    'DOMINICA',
                                                    'DOMINICAN REPUBLIC',
                                                    'ECUADOR',
                                                    'EGYPT',
                                                    'EL SALVADOR',
                                                    'EQUATORIAL GUINEA',
                                                    'ERITREA',
                                                    'ESTONIA',
                                                    'ESWATINI',
                                                    'ETHIOPIA',
                                                    'FIJI',
                                                    'FINLAND',
                                                    'FRANCE',
                                                    'GABON',
                                                    'GAMBIA',
                                                    'GEORGIA',
                                                    'GERMANY',
                                                    'GHANA',
                                                    'GREECE',
                                                    'GRENADA',
                                                    'GUATEMALA',
                                                    'GUINEA',
                                                    'GUINEA-BISSAU',
                                                    'GUYANA',
                                                    'HAITI',
                                                    'HONDURAS',
                                                    'HUNGARY',
                                                    'ICELAND',
                                                    'INDIA',
                                                    'INDONESIA',
                                                    'IRAN',
                                                    'IRAQ',
                                                    'IRELAND',
                                                    'ISRAEL',
                                                    'ITALY',
                                                    'JAMAICA',
                                                    'JAPAN',
                                                    'JORDAN',
                                                    'KAZAKHSTAN',
                                                    'KENYA',
                                                    'KIRIBATI',
                                                    'KUWAIT',
                                                    'KYRGYZSTAN',
                                                    'LAOS',
                                                    'LATVIA',
                                                    'LEBANON',
                                                    'LESOTHO',
                                                    'LIBERIA',
                                                    'LIBYA',
                                                    'LIECHTENSTEIN',
                                                    'LITHUANIA',
                                                    'LUXEMBOURG',
                                                    'MADAGASCAR',
                                                    'MALAWI',
                                                    'MALAYSIA',
                                                    'MALDIVES',
                                                    'MALI',
                                                    'MALTA',
                                                    'MARSHALL ISLANDS',
                                                    'MAURITANIA',
                                                    'MAURITIUS',
                                                    'MEXICO',
                                                    'MICRONESIA',
                                                    'MOLDOVA',
                                                    'MONACO',
                                                    'MONGOLIA',
                                                    'MONTENEGRO',
                                                    'MOROCCO',
                                                    'MOZAMBIQUE',
                                                    'MYANMAR',
                                                    'NAMIBIA',
                                                    'NAURU',
                                                    'NEPAL',
                                                    'NETHERLANDS',
                                                    'NEW ZEALAND',
                                                    'NICARAGUA',
                                                    'NIGER',
                                                    'NIGERIA',
                                                    'NORTH KOREA',
                                                    'NORTH MACEDONIA',
                                                    'NORWAY',
                                                    'OMAN',
                                                    'PAKISTAN',
                                                    'PALAU',
                                                    'PALESTINE',
                                                    'PANAMA',
                                                    'PAPUA NEW GUINEA',
                                                    'PARAGUAY',
                                                    'PERU',
                                                    'PHILIPPINES',
                                                    'POLAND',
                                                    'PORTUGAL',
                                                    'QATAR',
                                                    'ROMANIA',
                                                    'RUSSIA',
                                                    'RWANDA',
                                                    'SAINT KITTS AND NEVIS',
                                                    'SAINT LUCIA',
                                                    'SAINT VINCENT AND THE GRENADINES',
                                                    'SAMOA',
                                                    'SAN MARINO',
                                                    'SAO TOME AND PRINCIPE',
                                                    'SAUDI ARABIA',
                                                    'SENEGAL',
                                                    'SERBIA',
                                                    'SEYCHELLES',
                                                    'SIERRA LEONE',
                                                    'SINGAPORE',
                                                    'SLOVAKIA',
                                                    'SLOVENIA',
                                                    'SOLOMON ISLANDS',
                                                    'SOMALIA',
                                                    'SOUTH AFRICA',
                                                    'SOUTH KOREA',
                                                    'SOUTH SUDAN',
                                                    'SPAIN',
                                                    'SRI LANKA',
                                                    'SUDAN',
                                                    'SURINAME',
                                                    'SWEDEN',
                                                    'SWITZERLAND',
                                                    'SYRIA',
                                                    'TAIWAN',
                                                    'TAJIKISTAN',
                                                    'TANZANIA',
                                                    'THAILAND',
                                                    'TIMOR-LESTE',
                                                    'TOGO',
                                                    'TONGA',
                                                    'TRINIDAD AND TOBAGO',
                                                    'TUNISIA',
                                                    'TURKEY',
                                                    'TURKMENISTAN',
                                                    'TUVALU',
                                                    'UGANDA',
                                                    'UKRAINE',
                                                    'UNITED ARAB EMIRATES',
                                                    'UNITED KINGDOM',
                                                    'UNITED STATES',
                                                    'URUGUAY',
                                                    'UZBEKISTAN',
                                                    'VANUATU',
                                                    'VATICAN CITY',
                                                    'VENEZUELA',
                                                    'VIETNAM',
                                                    'YEMEN',
                                                    'ZAMBIA',
                                                    'ZIMBABWE',
                                                ];
                                            @endphp

                                            <div class="col-md-3" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label"> Country</label>
                                                    <div class="col-sm-8">
                                                        <select name="country" id="country" class="form-control">
                                                            <option value="">SELECT</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country }}"
                                                                    @if (strtoupper($country) == $record->country) selected @endif>
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
                                                        <input type="text" class="form-control"
                                                            id="destination_address" name="destination_address"
                                                            value="{{ $record->destination_address }}"
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
                                                            name="ticket_number" value="{{ $record->ticket_number }}"
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
                                                            value="{{ $record->departure_flight_number }}"
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
                                                            value="{{ $record->return_flight_number }}"
                                                            placeholder="Return Flight Number">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Departure Date</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="departure_date" class="form-control"
                                                            id="demo" value="{{ $record->departure_date }}">
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
                                                            id="backdate" value="{{ $record->return_date }}">
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
                                                            name="etd" value="{{ $record->etd }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" id="unIdDiv">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label"> ETA</label>
                                                    <div class="col-sm-8">
                                                        <input type="time" class="form-control" id="eta"
                                                            name="eta" value="{{ $record->eta }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="name" class="col-sm-4 col-form-label">Passport</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="passport_number"
                                                            name="passport_number"value="{{ $record->passport_number }}"
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
                                                            name="passport_expiry_date"value="{{ $record->passport_expiry_date }}"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3" id="coyDiv">
                                                <div class="form-group row">
                                                    <label for="colFormLabel"
                                                        class="col-sm-4 col-form-label">Amount</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="amount"
                                                            name="amount" value="{{ $record->amount }}"
                                                            placeholder="Amount">
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
                                                            <option value="GAF"
                                                                @if ($record->sponsorship == 'GAF') selected @endif>GAF
                                                            </option>
                                                            <option value="SELF-SPONSORSHIP"
                                                                @if ($record->sponsorship == 'SELF-SPONSORSHIP') selected @endif>
                                                                SELF-SPONSORSHIP</option>
                                                            <option value="ORGANIZATION"
                                                                @if ($record->sponsorship == 'ORGANIZATION') selected @endif>
                                                                ORGANIZATION</option>
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
                                                            name="responsibility" value="{{ $record->responsibility }}"
                                                            placeholder="Responsibility">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="inputPassword3"
                                                        class="col-sm-4 col-form-label">Status</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control select" name="status">
                                                            <option value="">Select</option>
                                                            <option value="0"
                                                                {{ $record->status == 0 ? 'selected' : '' }}>STANDBY
                                                            </option>
                                                            <option value="1"
                                                                {{ $record->status == 1 ? 'selected' : '' }}>APPROVED
                                                            </option>
                                                            <option value="2"
                                                                {{ $record->status == 2 ? 'selected' : '' }}>DEPARTED
                                                            </option>
                                                            <option value="3"
                                                                {{ $record->status == 3 ? 'selected' : '' }}>CANCELLED
                                                            </option>
                                                            <option value="4"
                                                                {{ $record->status == 4 ? 'selected' : '' }}>SCHEDULED
                                                            </option>
                                                            <option value="5"
                                                                {{ $record->status == 5 ? 'selected' : '' }}>RETURNED
                                                            </option>
                                                        </select>
                                                        @error('status')
                                                            <span class="btn btn-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3" id="coyDiv">
                                                <div class="form-group row">
                                                    <label for="colFormLabelLg"
                                                        class="col-sm-4 col-form-label ">Remarks</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control"
                                                            name="remarks" value="{{ $record->remarks }}"
                                                            placeholder="remarks">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="history" role="tabpanel"
                                        aria-labelledby="history-tab">
                                        <div class="row align-items-center m-l-0">
                                            <div class="dt-responsive table-responsive">
                                                <table id="main-report" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                No.
                                                            </th>
                                                            <th>#SER</th>
                                                            <th>RANK</th>
                                                            <th>PERSONNEL NAME</th>
                                                            <th>GENDER</th>
                                                            <th>MISSION</th>
                                                            <th>GHANBATT</th>
                                                            <th>APPOINTMENT</th>
                                                            <th>START DATE</th>
                                                            <th>END DATE</th>
                                                            <th>ACHIEVEMENTS</th>
                                                            <th>REMARKS</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn  btn-success">Update Record</button>
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
        document.getElementById("back").setAttribute('min', minDate);
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
@endsection
