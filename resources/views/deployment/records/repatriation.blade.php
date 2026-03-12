@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="user-profile user-card mb-4">
        <div class="card-body py-0">
            <div class="user-about-block m-0">
                <div class="row">
                    <div class="col-md-12 mt-md-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="mb-0 text-muted">SERVICE NUMBER: <b>{{ $data->svcnumber }}</b></p>
                                        <p class="mb-0 text-muted">FIRST NAME: <b>{{ $data->first_name }}</b></p>
                                        <p class="mb-0 text-muted">ARM OF SERVICE: <b>{{ $data->arm_of_service }}</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="mb-0 text-muted">RANK: <b>{{ $data->rank_name }}</b></p>
                                        <p class="mb-0 text-muted">GENDER: <b>{{ $data->gender }}</b></p>
                                        <p class="mb-0 text-muted">UNIT NAME: <b>{{ $data->unit_name }}</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="mb-0 text-muted">SURNAME: <b>{{ $data->surname }}</b></p>
                                        <p class="mb-0 text-muted">MISSION: <b>{{ $data->mission_name }}</b></p>
                                        <p class="mb-0 text-muted">COUNTRY: <b>{{ $data->country }}</b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="mb-0 text-muted">OTHER NAMES: <b>{{ $data->othernames }}</b></p>
                                        <p class="mb-0 text-muted">APPOINTMENT: <b>{{ $data->appointment_name }}</b></p>
                                        <p class="mb-0 text-muted">STATUS:
                                            @if ($data->status == 2)
                                                <span class="badge badge-success mr-1">DEPLOYED</span>
                                            @endif
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <br> <br>
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('update-personnel-repatriation', $data->uuid) }}" method="POST">
                            @csrf
                            {{-- <div class="form-group">
                                <label for="repatriation_remarks">Repatriation Reason</label>
                                <input type="text" class="form-control form-control-lg" name="repatriation_remarks"
                                    value="{{ old('repatriation_remarks') }}" placeholder="Repatriation Remarks">
                                @error('repatriation_remarks')
                                    <span class="btn btn-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label for="exampleInputPassword1">Repatriation Reason</label>
                                <input type="text" class="form-control form-control-lg" name="remarks"
                                    value="{{ old('remarks') }}" placeholder="Remarks">
                                @error('remarks')
                                    <span class="btn btn-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn  btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
