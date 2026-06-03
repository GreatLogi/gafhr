@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">HR Hierarchy Setup</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hierarchy.mech') }}">HR Hierarchy</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ strtoupper(str_replace('_', ' ', $type)) }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">{{ strtoupper(str_replace('_', ' ', $type)) }}</h4>
                <small class="text-muted">Manage this hierarchy level on its own page.</small>
            </div>
            <a href="{{ route('hierarchy.mech') }}" class="btn btn-outline-primary">Back To Hierarchy Menu</a>
        </div>
    </div>

    @if ($type === 'ghq')
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Add GHQ</h5></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('hierarchy.ghq.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>GHQ Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" class="form-control" name="location" value="{{ old('location') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Save GHQ</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Existing GHQ Records</h5></div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered nowrap">
                            <thead><tr><th>#</th><th>Name</th><th>Location</th><th>Action</th></tr></thead>
                            <tbody>
                                @foreach ($ghqs as $key => $record)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $record->name }}</td>
                                        <td>{{ $record->location }}</td>
                                        <td><a href="{{ route('hierarchy.ghq.edit', $record->uuid) }}" class="btn btn-sm btn-primary"><i class="feather icon-edit"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($type === 'directorate')
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Add Directorate</h5></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('hierarchy.directorate.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>GHQ</label>
                                <select class="form-control" name="ghq_id">
                                    <option value="">Select GHQ</option>
                                    @foreach ($ghqs as $ghq)
                                        <option value="{{ $ghq->id }}">{{ $ghq->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Directorate Name</label>
                                <input type="text" class="form-control" name="directorate_name">
                            </div>
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" class="form-control" name="directorate_code">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" name="description">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Directorate</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Existing Directorates</h5></div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered nowrap">
                            <thead><tr><th>#</th><th>Name</th><th>GHQ</th><th>Code</th><th>Action</th></tr></thead>
                            <tbody>
                                @foreach ($directorates as $key => $record)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $record->directorate_name }}</td>
                                        <td>{{ $record->ghq->name ?? '' }}</td>
                                        <td>{{ $record->directorate_code }}</td>
                                        <td><a href="{{ route('hierarchy.directorate.edit', $record->uuid) }}" class="btn btn-sm btn-primary"><i class="feather icon-edit"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($type === 'service_hq')
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Add Service HQ</h5></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('hierarchy.service-hq.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>GHQ</label>
                                <select class="form-control" name="ghq_id">
                                    <option value="">Select GHQ</option>
                                    @foreach ($ghqs as $ghq)
                                        <option value="{{ $ghq->id }}">{{ $ghq->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Service Name</label>
                                <input type="text" class="form-control" name="service_name">
                            </div>
                            <div class="form-group">
                                <label>Service Code</label>
                                <input type="text" class="form-control" name="service_code">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Service HQ</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Existing Service HQ Records</h5></div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered nowrap">
                            <thead><tr><th>#</th><th>Name</th><th>GHQ</th><th>Code</th><th>Action</th></tr></thead>
                            <tbody>
                                @foreach ($serviceHqs as $key => $record)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $record->service_name }}</td>
                                        <td>{{ $record->ghq->name ?? '' }}</td>
                                        <td>{{ $record->service_code }}</td>
                                        <td><a href="{{ route('hierarchy.service-hq.edit', $record->uuid) }}" class="btn btn-sm btn-primary"><i class="feather icon-edit"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($type === 'command_hq')
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Add Command HQ</h5></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('hierarchy.command-hq.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>Service HQ</label>
                                <select class="form-control" name="service_hq_id">
                                    <option value="">Select Service HQ</option>
                                    @foreach ($serviceHqs as $serviceHq)
                                        <option value="{{ $serviceHq->id }}">{{ $serviceHq->service_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Command Name</label>
                                <input type="text" class="form-control" name="command_name">
                            </div>
                            <div class="form-group">
                                <label>Command Code</label>
                                <input type="text" class="form-control" name="command_code">
                            </div>
                            <div class="form-group">
                                <label>Command Type</label>
                                <input type="text" class="form-control" name="command_type">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Command HQ</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Existing Command HQ Records</h5></div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered nowrap">
                            <thead><tr><th>#</th><th>Name</th><th>Service HQ</th><th>Code</th><th>Action</th></tr></thead>
                            <tbody>
                                @foreach ($commandHqs as $key => $record)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $record->command_name }}</td>
                                        <td>{{ $record->serviceHq->service_name ?? '' }}</td>
                                        <td>{{ $record->command_code }}</td>
                                        <td><a href="{{ route('hierarchy.command-hq.edit', $record->uuid) }}" class="btn btn-sm btn-primary"><i class="feather icon-edit"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
