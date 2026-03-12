<div class="row justify-content-center">
    <!-- liveline-section start -->
    <div class="col-sm-12">
        <div class="card user-profile-list">
            <div class="card-header">
                <h5>Details of Schedule</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center m-l-0">
                    <div class="col-sm-6 text-left"><br />
                        <p>Perform these Actions on Reschedule.</p>
                    </div>
                    <div class="col-sm-6 text-right"><br />
                    </div>
                    <div class="dt-responsive table-responsive">
                        <div class="dt-responsive table-responsive">
                            <table id="example1" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="1"
                                                    id="contactstable-select-all">
                                                <label class="custom-control-label" for="contactstable-select-all">
                                                </label>
                                            </div>
                                        </th>
                                        <th>#SVC ID</th>
                                        <th>PERSONNEL</th>
                                        <th>GENDER</th>
                                        <th>MISSION</th>
                                        <th>LOCATION</th>
                                        <th>DEPARTURE</th>
                                        <th>DAY(S) LEFT FOR DEPARTURE</th>
                                        <th>ARRIVAL</th>
                                        <th>STATUS</th>
                                        <th>APPROVING</th>
                                        <th>CANCELLATION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($personnel_reschedule as $record)
                                        @php
                                            $full_name = $record->surname . ' ' . $record->othernames;
                                        @endphp
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $record->svcnumber }}</td>
                                            <td>{{ $record->full_name }}</td>
                                            <td>{{ $record->gender }}</td>
                                            <td>{{ $record->location }}</td>
                                            <td>{{ date('d F, Y', strtotime($record->departure_date)) }}</td>
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
                                                    Day(s) left for departure
                                                @endif
                                            </td>
                                            <td>{{ date('d F, Y', strtotime($record->return_date)) }}</td>
                                            <td>
                                                {{-- @if ($record->status == '0')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($record->status == '2')
                                                <span class="badge badge-danger">Cancelled</span>
                                            @elseif($record->status == '3')
                                                <span class="badge badge-info">Rescheduled</span>
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
                                            <td>
                                                @if ($record->status == '3')
                                                    <a href="{{ route('course.approve', $record->id) }} "
                                                        class="badge badge-success sm" title="Approved"
                                                        id="ApproveBtn">
                                                        <i class="fas fa-check-circle"></i> </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($record->status == '3')
                                                    <a href="{{ route('course.approve.cancel', $record->id) }} "
                                                        class="badge badge-danger sm" title="Cancelled"
                                                        id="CancelBtn">
                                                        <i class="fas fa-check-circle"></i> </a>
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