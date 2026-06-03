@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit HR Hierarchy</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Mechanizations</a></li>
                        <li class="breadcrumb-item"><a href="#">HR Hierarchy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @if ($type === 'ghq')
                        <form action="{{ route('hierarchy.ghq.update', $record->uuid) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">GHQ Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $record->name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Location</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="location" value="{{ old('location', $record->location) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update GHQ</button>
                        </form>
                    @elseif ($type === 'directorate')
                        <form action="{{ route('hierarchy.directorate.update', $record->uuid) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">GHQ</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="ghq_id">
                                                @foreach ($ghqs as $ghq)
                                                    <option value="{{ $ghq->id }}" {{ $ghq->id === $record->ghq_id ? 'selected' : '' }}>{{ $ghq->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="directorate_name" value="{{ old('directorate_name', $record->directorate_name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="directorate_code" value="{{ old('directorate_code', $record->directorate_code) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="description" value="{{ old('description', $record->description) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Directorate</button>
                        </form>
                    @elseif ($type === 'service_hq')
                        <form action="{{ route('hierarchy.service-hq.update', $record->uuid) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">GHQ</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="ghq_id">
                                                @foreach ($ghqs as $ghq)
                                                    <option value="{{ $ghq->id }}" {{ $ghq->id === $record->ghq_id ? 'selected' : '' }}>{{ $ghq->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Service Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="service_name" value="{{ old('service_name', $record->service_name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="service_code" value="{{ old('service_code', $record->service_code) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Service HQ</button>
                        </form>
                    @elseif ($type === 'command_hq')
                        <form action="{{ route('hierarchy.command-hq.update', $record->uuid) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Service HQ</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="service_hq_id">
                                                @foreach ($serviceHqs as $serviceHq)
                                                    <option value="{{ $serviceHq->id }}" {{ $serviceHq->id === $record->service_hq_id ? 'selected' : '' }}>{{ $serviceHq->service_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Command Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="command_name" value="{{ old('command_name', $record->command_name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="command_code" value="{{ old('command_code', $record->command_code) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Type</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="command_type" value="{{ old('command_type', $record->command_type) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Command HQ</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
