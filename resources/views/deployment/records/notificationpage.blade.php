@extends('admin.admin_master')
@section('admin')

  <!-- [ breadcrumb ] start -->
  <div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Records</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#!">Notifications</a></li>
                    <li class="breadcrumb-item"><a href="#!">Reminding</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->


<div class="row justify-content-center">
    <!-- liveline-section start -->
    <div class="col-sm-12">

        <div class="card user-profile-list">
            <div class="card-header">
                <h5>Details of Course Travel Records</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center m-l-0">
                    <div class="col-sm-6 text-left"><br />
                        <p>Perform these Actions on Record.</p>
                    </div>
                    <div class="col-sm-6 text-right"><br />
                        <div class="btn-group mb-2 mr-2" style="display: inline-block;">
                            <a href="{{ route('create') }}" class="btn  btn-primary " aria-haspopup="true"
                                aria-expanded="false"><i class="feather icon-plus"></i>Add Records</a>
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
                                        <th>#SER</th>
                                        <th>PERSONNEL</th>
                                        <th>MISSION</th>
                                        <th>COUNTRY</th>
                                        <th>LOCATION</th>
                                        <th>DEPARTURE</th>
                                        <th>DAYS LEFT FOR DEPARTURE</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
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
                                            <td>
                                                <h6 class="table-avatar">
                                                    <a href="{{ route('record.details', $record->id) }}">
                                                        <span>{{ $record->svcnumber }}</span></a>
                                                </h6>
                                            </td>
                                            <td>
                                                {{ $record->full_name }}
                                            </td>
                                            <td>{{ $record->course_name }}</td>
                                            <td>{{ $record->country }}</td>
                                            <td>{{ $record->location }}</td>
                                            <td> {{ date('d F, Y', strtotime($record->departure_date)) }}</td>
                                            <td>
                                                @if ($record->departuredays < 0)
                                                    <span class="badge badge-danger mr-1 ">
                                                        {{ $record->departuredays }}
                                                        Days passed
                                                    </span>
                                                @elseif ($record->departuredays == 0)
                                                    Departed
                                                @else
                                                    {{ $record->departuredays }}
                                                    Days left
                                                @endif
                                            </td>
                                            <td>
                                                @if ($record->status == '5')
                                                    <span class="badge badge-warning mr-1 ">Pending</span>
                                                @elseif($record->status == '1')
                                                    <span class="badge badge-success mr-1 ">Travelled</span>
                                                @elseif($record->status == '2')
                                                    <span class="badge badge-danger mr-1 ">Cancelled</span>
                                                @elseif($record->status == '3')
                                                    <span class="badge badge-info mr-1 ">Rescheduled</span>
                                                @elseif($record->status == '4')
                                                    <span class="badge badge-secondary mr-1 ">Returned</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('record.details', $record->id) }}"><i
                                                        class="fa fa-eye"> </i></a>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('course.edit', $record->id) }}"><i
                                                        class="feather icon-edit"> </i></a>
                                                @if ($record->status == '0')
                                                    <a class="btn btn-danger btn-sm" title="Delete Data" id="delete"
                                                        href=""><i class="feather icon-trash-2"></i></a>
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

@endsection
