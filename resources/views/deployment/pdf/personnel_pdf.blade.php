@extends('admin.admin_master')
@section('admin')
    <!-- [ Main Content ] start -->

    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Travel</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Individual Report Form</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ Invoice ] start -->
        <div class="container" id="printTable">
            <div>
                <div class="card">
                    <!DOCTYPE html>
                    <html>

                    <head>
                        <style>
                            #content {
                                padding: 2.0em;
                            }

                            #customers {
                                font-family: Arial, Helvetica, sans-serif;
                                border-collapse: collapse;
                                width: 100%;
                            }

                            #customers td,
                            #customers th {
                                border: 1px solid rgb(227, 225, 240);
                                padding: 8px;
                            }

                            #customers tr:nth-child(even) {
                                background-color: #f2f2f2;
                            }

                            #customers tr:hover {
                                background-color: #ddd;
                            }

                            #customers tr.noborder td {
                                border: 0;
                            }

                            .blank_row {
                                height: 5px;
                                background-color: white;
                            }

                            #customers th {
                                padding-top: 12px;
                                padding-bottom: 12px;
                                text-align: left;
                                background-color: #6c8ff0;
                                color: white;
                                /* width: 15%; */
                            }
                        </style>
                    </head>

                    <body>
                        <div id="content">
                            <table id="customers">
                                <tr class="noborder">
                                    <td>
                                        <h4 style="">PERSONNEL DEPLOYMENT DETAILS</h4>
                                        <h5>
                                            Directorate of International Peace Support Operation<br>
                                            Headquarters Burma Camp, Accra, Ghana.<br>
                                            <b>Phone</b> : +233302774511<br>
                                            <b>Email</b> : gafto@gaf.mil.gh
                                        </h5>
                                    </td>
                                    <td>
                                        @if ($data->personnel_image)
                                            <img src="{{ asset($data->personnel_image) }}"
                                                style="width: 170px; height: 160px;" align="right">
                                        @else
                                            <img src="{{ asset('upload/personnel.jpeg') }}"
                                                style="width: 160px; height: 200px;" align="right">
                                        @endif
                                    </td>
                                </tr>
                                <h5 style="text-align:center;">RESTRICTED
                                    <hr>
                                    {{-- <b>Issued by - </b> <span class="pull-right">SRL #:{{ Auth::user()->name }}</span> --}}
                                </h5>
                            </table>
                            <table id="customers">
                                <tr>
                                    <th colspan="3">BIO DATA</th>

                                </tr>
                                <tr>
                                    <td colspan="3"><b>SERVICE NO.</b></td>
                                    <td colspan="3">{{ $data->svcnumber }}</td>
                                    <td colspan="3"><b>RANK: </b></td>
                                    <td colspan="3">{{ $data->rank_name }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>SURNAME: </b></td>
                                    <td colspan="3">{{ $data->surname }}</td>
                                    <td colspan="3"><b>OTHERNAMES: </b></td>
                                    <td colspan="3">{{ $data->first_name }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>UNIT: </b></td>
                                    <td colspan="3">{{ $data->unit_name }}</td>
                                    <td colspan="3"><b>CATEGPRY: </b></td>
                                    <td colspan="3">{{ $data->service_category }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>EMAIL: </b></td>
                                    <td colspan="3">{{ $data->email }}</td>
                                    <td colspan="3"><b>MOBILE NO: </b></td>
                                    <td colspan="3">{{ $data->mobile_no }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>GENDER: </b></td>
                                    <td colspan="3">{{ $data->gender }}</td>
                                    <td colspan="3"><b>BLOOD GROUP: </b></td>
                                    <td colspan="3">{{ $data->blood_group }}</td>
                                </tr>
                                <tr class="blank_row noborder">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <th colspan="3">TRAVELED</th>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>PURPOSE: </b></td>
                                    <td colspan="3">{{ $data->purpose }}</td>
                                    <td colspan="3"><b>COUNTRY: </b></td>
                                    <td colspan="3">{{ $data->country }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>DEPARTURE DATE: </b></td>
                                    <td colspan="3"> {{ date('d F, Y', strtotime($data->departure_date)) }}</td>
                                    <td colspan="3"><b>RETURN DATE: </b></td>
                                    <td colspan="3"> {{ date('d F, Y', strtotime($data->return_date)) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>DEPARTURE FLIGHT NUMBER: </b></td>
                                    <td colspan="3">{{ $data->departure_flight_number }}</td>
                                    <td colspan="3"><b>RETURN FLIGHT NUMBER: </b></td>
                                    <td colspan="3">{{ $data->return_flight_number }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>AMOUNT: </b></td>
                                    <td colspan="3">{{ $data->amount }}</td>
                                    <td colspan="3"><b>SPONSORSHIP: </b></td>
                                    <td colspan="3">{{ $data->sponsorship }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>ETD: </b></td>
                                    <td colspan="3">{{ \Carbon\Carbon::parse($data->etd)->format('g:i A') }}</td>
                                    <td colspan="3"><b>ETA: </b></td>
                                    <td colspan="3">{{ \Carbon\Carbon::parse($data->eta)->format('g:i A') }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3"><b>PASSPORT NO: </b></td>
                                    <td colspan="3">{{ $data->passport_number }}</td>
                                    <td colspan="3"><b>PASSPORT EXPIRY: </b></td>
                                    <td colspan="3">{{ $data->passport_expiry_date }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>REMARKS: </b></td>
                                    <td colspan="3">{{ $data->remarks }}</td>
                                    <td colspan="3"><b>STATUS: </b></td>
                                    <td colspan="3">
                                        @if ($data->status == '0')
                                            <span class="badge badge-warning mr-1  ">PENDING</span>
                                        @elseif($data->status == '1')
                                            <span class="badge badge-primary mr-1 ">APPROVED</span>
                                        @elseif($data->status == '2')
                                            <span class="badge badge-success mr-1 ">TRAVELED</span>
                                        @elseif($data->status == '3')
                                            <span class="badge badge-danger mr-1 ">CANCELLED</span>
                                        @elseif($data->status == '4')
                                            <span class="badge badge-primary mr-1 ">SCHEDULED</span>
                                        @elseif($data->status == '5')
                                            <span class="badge badge-success mr-1 ">RETURNED</span>
                                        @elseif($data->status == '6')
                                            <span class="badge badge-danger mr-1 ">REPATRIATED</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3"><b>RESPONSIBILITY: </b></td>
                                    <td colspan="3">{{ $data->responsibility }}</td>
                                    <td colspan="3"></td>
                                    <td colspan="3"></td>
                                </tr>
                            </table>
                            <br>

                            <hr>
                            <h5 style="text-align:center;">
                                RESTRICTED
                            </h5>
                            <h4 style="text-align:center;">
                                <i style="font-size: 10px; float: right;">Printed at: {{ date('d M Y  h:i:sa') }}</i>
                            </h4>
                        </div>
                    </body>

                    </html>
                </div>
            </div>
        </div>

    </div>
    <!-- [ Main Content ] end -->
    <div class="row text-center">
        <div class="col-sm-12 invoice-btn-group text-center">
            <button type="button" class="btn waves-effect waves-light btn-primary btn-print-invoice m-b-10">Print</button>
        </div>
    </div>
    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>

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
    <script>
        function printData() {
            var divToPrint = document.getElementById("printTable");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }
        $('.btn-print-invoice').on('click', function() {
            printData();
        })
    </script>


    </body>

    </html>
@endsection
