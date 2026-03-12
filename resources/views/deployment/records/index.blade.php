@extends('admin.admin_master')
@section('admin')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Records</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">View</a></li>
                        <li class="breadcrumb-item"><a href="#!">Records</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
        #example {
            font-size: 19px;
        }

        .input_container {
            border: 1px solid #e5e5e5;
        }

        input[type=file]::file-selector-button {
            background-color: #fff;
            color: #000;
            border: 0px;
            border-right: 1px solid #e5e5e5;
            padding: 10px 15px;
            margin-right: 20px;
            transition: .5s;
        }

        input[type=file]::file-selector-button:hover {
            background-color: #eee;
            border: 0px;
            border-right: 1px solid #e5e5e5;
        }
    </style>

    <div class="row justify-content-center">
        <!-- liveline-section start -->
        <div class="col-sm-12">
            <div class="card user-profile-list">
                <div class="card-header">
                    <nav class="navbar justify-content-between p-0 align-items-center">
                        <h5>Details of GAFTO Records</h5>
                        <div class="input-group" style="width: auto;">
                            {{-- <div class="col-auto">
                                <div class="btn-group">
                                    <form action="{{ route('import-record') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="input_container">
                                                <input type="file" name="file" id="fileUpload" accept=".xlsx, .csv">
                                            </div>
                                            <div class="col-auto">
                                                <button class="btn btn-info">Import Excel File</button>
                                            </div>
                                        </div>

                                        @error('file')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }} Please upload a valid file (xlsx, csv).
                                            </div>
                                        @enderror
                                    </form>
                                </div>
                            </div> --}}
                            <div class="col text-right">
                                <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                    <a href="{{ route('create-record') }}" class="btn  btn-success " aria-haspopup="true"
                                        aria-expanded="false"><i class="feather icon-plus"></i>Add
                                        Records</a>
                                </div>
                            </div>
                        </div>

                    </nav>
                </div>
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="dt-responsive table-responsive">
                            <table id="mission" class="table table-striped table-bordered nowrap" data-autoscroll>
                                <thead>
                                    <tr>
                                        <th>
                                            No.
                                        </th>
                                        <th>#SVC ID</th>
                                        <th>RANK</th>
                                        <th>SURNAME</th>
                                        <th>OTHERNAMES</th>
                                        <th>FIRST NAME</th>
                                        <th>GENDER</th>
                                        <th>PURPOSE</th>
                                        <th>DESTINATION ADDRESS</th>
                                        <th>FLIGHT NUMBER</th>
                                        <th>TICKET NUMBER</th>
                                        <th>COUNTRY</th>
                                        <th>DEPARTURE DATE</th>
                                        <th>RETURN DATE</th>
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
            $('#mission').DataTable({
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
                // ajax: "{{ route('api-mission-record') }}",
                // type: 'POST',
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
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
                        data: 'surname',
                        name: 'surname'
                    },
                    {
                        data: 'othernames',
                        name: 'othernames'
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'purpose',
                        name: 'purpose'
                    },
                    {
                        data: 'destination_address',
                        name: 'destination_address'
                    },
                    {
                        data: 'departure_flight_number',
                        name: 'departure_flight_number'
                    },
                    {
                        data: 'ticket_number',
                        name: 'ticket_number'
                    },
                    {
                        data: 'country',
                        name: 'country',

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
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],

            });
        });
    </script>
@endsection
