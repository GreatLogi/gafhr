@extends('admin.admin_master')
@section('admin')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .form-check-label {
            text-transform: capitalize;
        }
    </style>
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Create User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#!">Add User</a></li>
                        <li class="breadcrumb-item"><a href="#!">Dashbaord</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Create New Role</h4>
                    @include('systemsetting.users.part.message')

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">User Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">User Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter Email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password">Assign Roles</label>
                                <select name="roles[]" id="roles" class="form-control select2" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
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
                                        <option value="{{ $ghq->id }}">{{ $ghq->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="department_id">Department Scope</label>
                                <select name="department_id" id="department_id" class="form-control hierarchy-filter"
                                    data-parent="ghq_id" data-child-key="ghq_id">
                                    <option value="">All Departments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" data-ghq-id="{{ $department->ghq_id }}">{{ $department->department }}</option>
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
                                        <option value="{{ $directorate->id }}" data-ghq-id="{{ $directorate->ghq_id }}">{{ $directorate->directorate_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="service_hq_id">Service HQ Scope</label>
                                <select name="service_hq_id" id="service_hq_id" class="form-control hierarchy-filter"
                                    data-parent="ghq_id" data-child-key="ghq_id" data-require-parent="true">
                                    <option value="">All Service HQ</option>
                                    @foreach ($serviceHqs as $serviceHq)
                                        <option value="{{ $serviceHq->id }}" data-ghq-id="{{ $serviceHq->ghq_id }}">{{ $serviceHq->service_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="command_hq_id">Command HQ Scope</label>
                                <select name="command_hq_id" id="command_hq_id" class="form-control hierarchy-filter"
                                    data-parent="service_hq_id" data-child-key="service_hq_id" data-require-parent="true">
                                    <option value="">All Commands</option>
                                    @foreach ($commandHqs as $commandHq)
                                        <option value="{{ $commandHq->id }}" data-service-hq-id="{{ $commandHq->service_hq_id }}">{{ $commandHq->command_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="unit_id">Unit Scope</label>
                                <select name="unit_id" id="unit_id" class="form-control hierarchy-filter"
                                    data-parent="command_hq_id" data-child-key="command_hq_id" data-require-parent="true">
                                    <option value="">All Units</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" data-command-hq-id="{{ $unit->command_hq_id }}">{{ $unit->unit_name ?? $unit->unit }}</option>
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
                const requireParent = selectEl.dataset.requireParent === 'true';
                Array.from(selectEl.options).forEach((opt, index) => {
                    if (index === 0) {
                        opt.hidden = false;
                        return;
                    }
                    const dataKey = `data-${childKey.replace(/_/g, '-')}`;
                    const optionValue = String(opt.getAttribute(dataKey) || '');
                    const visible = requireParent ? (parentValue && optionValue === parentValue) : (!parentValue || optionValue === parentValue);
                    opt.hidden = !visible;
                    if (!visible && opt.selected) {
                        opt.selected = false;
                    }
                });

                selectEl.disabled = requireParent && !parentValue;
            };
            const hierarchySelects = Array.from(document.querySelectorAll('.hierarchy-filter'));
            const syncChildren = function(parentId) {
                hierarchySelects
                    .filter((selectEl) => selectEl.dataset.parent === parentId)
                    .forEach((selectEl) => {
                        syncHierarchySelect(selectEl);
                        syncChildren(selectEl.id);
                    });
            };
            hierarchySelects.forEach((selectEl) => {
                const parent = document.getElementById(selectEl.dataset.parent);
                if (parent) {
                    parent.addEventListener('change', function() {
                        selectEl.value = '';
                        syncHierarchySelect(selectEl);
                        syncChildren(selectEl.id);
                    });
                }
            });
            syncChildren('ghq_id');
        });
    </script>
@endsection
