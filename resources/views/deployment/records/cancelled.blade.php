@extends('admin.admin_master')
@section('admin')
    <style>
        #example {
            font-size: 19px;
        }
    </style>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Mission</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">On Mission</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row justify-content-center">
        <!-- liveline-section start -->
        <div class="col-sm-12">

            <div class="card user-profile-list">
                <div class="card-header">
                    <h5>Details of cancellation</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center m-l-0">
                        <div class="col-sm-6 text-left"><br />
                            <p>Perform these Actions on Cancellation.</p>
                        </div>
                        <div class="col-sm-6 text-right"><br />
                            <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                                <a href="{{ route('create-record') }}"
                                    class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i
                                        class="fas fa-plus-circle"> </i></a>
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

                                            <th>#SVC ID</th>
                                            <th>PERSONNEL</th>
                                            <th>MISSION</th>
                                            <th>LOCATION</th>
                                            <th>DEPARTURE</th>
                                            <th>ARRIVAL</th>
                                            <th>STATUS</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($data as $record)
                                            @php
                                                $full_name = $record->surname . ' ' . $record->othernames;
                                            @endphp
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $record->svcnumber }}</td>
                                                <td>{{ $record->full_name }}</td>
                                                <td>{{ $record->course_name }}</td>
                                                <td>{{ $record->location }}</td>
                                                <td>{{ date('d F, Y', strtotime($record->departure_date)) }}</td>
                                                <td>{{ date('d F, Y', strtotime($record->return_date)) }}</td>
                                                <td>
                                                    {{-- @if ($record->status == '5')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($record->status == '2')
                                                        <span class="badge badge-danger">Cancelled</span>
                                                    @endif --}}
                                                    @if ($record->status == '5')
                                                        <span class="badge badge-warning mr-1">STANDBY</span>
                                                    @elseif($record->status == '1' && now()->toDateString() == date('Y-m-d', strtotime($record->departure_date)))
                                                        <span class="badge badge-success mr-1">DEPLOYED</span>
                                                    @elseif($record->status == '1')
                                                        <span class="badge badge-success mr-1">APPROVED</span>
                                                    @elseif($record->status == '2')
                                                        <span class="badge badge-danger mr-1">CANCELLED</span>
                                                    @elseif($record->status == '3')
                                                        <span class="badge badge-info mr-1">RESCHEDULED</span>
                                                    @elseif($record->status == '4')
                                                        <span class="badge badge-secondary mr-1">RETURNED</span>
                                                    @elseif($record->status == '6')
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


        <!-- liveline-section end -->
    </div>
    <!-- [ Main Content ] end -->
    <!-- [ Main Content ] end -->


    <!-- Modal -->

    </div>
    </div>



    <!-- [ Main Content ] end -->
@endsection

<script>
    function printData() {
        // var divToPrint = document.getElementById("printTable");
        // newWin = window.open("");
        // newWin.document.write("<link rel=\"stylesheet\" href=\"#"/>" );
        // newWin.document.write(divToPrint.outerHTML);
        // newWin.print();
        // newWin.close();
        // return true;
    }
    $('.btn-print-invoice').on('click', function() {
        printData();
    })

    function linkcolored(selected) {
        selected.style = 'color: black;';
    }

    function linkuncolored(selected) {
        selected.style = '';
    }
</script>
