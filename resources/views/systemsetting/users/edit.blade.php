@extends('admin.admin_master')
@section('admin')
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashbaord</a></li>
                        <li class="breadcrumb-item"><a href="#!">Edit User{{ $user->name }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit User - {{ $user->name }}</h4>
                    @include('systemsetting.users.part.message')

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">User Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="{{ $user->name }}">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">User Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password">Assign Roles</label>
                                <select name="roles[]" id="roles" class="form-control select2" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="ghq_id">GHQ Scope</label>
                                <select name="ghq_id" id="ghq_id" class="form-control hierarchy-select">
                                    <option value="">All GHQ</option>
                                    @foreach ($ghqs as $ghq)
                                        <option value="{{ $ghq->id }}" {{ $ghq->id === $user->ghq_id ? 'selected' : '' }}>{{ $ghq->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="department_id">Department Scope</label>
                                <select name="department_id" id="department_id" class="form-control hierarchy-filter"
                                    data-parent="ghq_id" data-child-key="ghq_id">
                                    <option value="">All Departments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" data-ghq-id="{{ $department->ghq_id }}" {{ $department->id === $user->department_id ? 'selected' : '' }}>{{ $department->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="directorate_id">Directorate Scope</label>
                                <select name="directorate_id" id="directorate_id" class="form-control hierarchy-filter"
                                    data-parent="ghq_id" data-child-key="ghq_id">
                                    <option value="">All Directorates</option>
                                    @foreach ($directorates as $directorate)
                                        <option value="{{ $directorate->id }}" data-ghq-id="{{ $directorate->ghq_id }}" {{ $directorate->id === $user->directorate_id ? 'selected' : '' }}>{{ $directorate->directorate_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="service_hq_id">Service HQ Scope</label>
                                <select name="service_hq_id" id="service_hq_id" class="form-control hierarchy-filter"
                                    data-parent="ghq_id" data-child-key="ghq_id">
                                    <option value="">All Service HQ</option>
                                    @foreach ($serviceHqs as $serviceHq)
                                        <option value="{{ $serviceHq->id }}" data-ghq-id="{{ $serviceHq->ghq_id }}" {{ $serviceHq->id === $user->service_hq_id ? 'selected' : '' }}>{{ $serviceHq->service_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="command_hq_id">Command HQ Scope</label>
                                <select name="command_hq_id" id="command_hq_id" class="form-control hierarchy-filter"
                                    data-parent="service_hq_id" data-child-key="service_hq_id">
                                    <option value="">All Commands</option>
                                    @foreach ($commandHqs as $commandHq)
                                        <option value="{{ $commandHq->id }}" data-service-hq-id="{{ $commandHq->service_hq_id }}" {{ $commandHq->id === $user->command_hq_id ? 'selected' : '' }}>{{ $commandHq->command_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="unit_id">Unit Scope</label>
                                <select name="unit_id" id="unit_id" class="form-control hierarchy-filter"
                                    data-parent="command_hq_id" data-child-key="command_hq_id">
                                    <option value="">All Units</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" data-command-hq-id="{{ $unit->command_hq_id }}" {{ $unit->id === $user->unit_id ? 'selected' : '' }}>{{ $unit->unit_name ?? $unit->unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            const syncHierarchySelect = function(selectEl) {
                const parentId = selectEl.dataset.parent;
                const childKey = selectEl.dataset.childKey;
                if (!parentId || !childKey) return;
                const parent = document.getElementById(parentId);
                const parentValue = String(parent?.value || '');
                Array.from(selectEl.options).forEach((opt, index) => {
                    if (index === 0) {
                        opt.hidden = false;
                        return;
                    }
                    const dataKey = `data-${childKey.replace(/_/g, '-')}`;
                    const optionValue = String(opt.getAttribute(dataKey) || '');
                    const visible = !parentValue || optionValue === parentValue;
                    opt.hidden = !visible;
                });
            };
            document.querySelectorAll('.hierarchy-filter').forEach((selectEl) => {
                const parent = document.getElementById(selectEl.dataset.parent);
                if (parent) {
                    parent.addEventListener('change', function() {
                        syncHierarchySelect(selectEl);
                    });
                }
                syncHierarchySelect(selectEl);
            });
        });
    </script>
@endsection
<script src="{{ asset('assets/js/pages/todo.js') }}"></script>
