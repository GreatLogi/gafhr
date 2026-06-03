@extends('admin.admin_master')
@section('admin')
    <style>
        :root {
            --user-page-bg: #f5f6f8;
            --user-card-bg: #ffffff;
            --user-border: #dfe3e8;
            --user-text: #2f3b4a;
            --user-muted: #6b7785;
            --user-accent: #2f6fad;
            --user-accent-hover: #255986;
        }

        .user-form-page {
            background: var(--user-page-bg);
            border-radius: 16px;
            padding: 20px;
        }

        .user-form-card {
            background: var(--user-card-bg);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            box-shadow: 0 12px 28px rgba(47, 59, 74, 0.08);
        }

        .user-form-title {
            color: var(--user-text);
            font-weight: 700;
            margin-bottom: 4px;
        }

        .user-form-subtitle {
            color: var(--user-muted);
            margin-bottom: 0;
        }

        .user-section {
            border: 1px solid var(--user-border);
            border-radius: 14px;
            padding: 18px;
            height: 100%;
        }

        .user-section-title {
            color: var(--user-text);
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            margin-bottom: 14px;
        }

        .form-label {
            color: var(--user-text);
            font-weight: 600;
        }

        .form-control,
        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single {
            border-radius: 10px !important;
            border-color: var(--user-border) !important;
            min-height: 42px;
        }

        .scope-hint {
            color: var(--user-muted);
            font-size: 0.85rem;
            margin-top: 10px;
        }

        .btn-user-save {
            background: var(--user-accent);
            border: 1px solid var(--user-accent);
            border-radius: 10px;
            color: #fff;
            font-weight: 600;
            padding: 0.65rem 1.4rem;
        }

        .btn-user-save:hover {
            background: var(--user-accent-hover);
            border-color: var(--user-accent-hover);
            color: #fff;
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item"><a href="#!">{{ $user->name }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="user-form-page">
        <div class="card user-form-card">
            <div class="card-body p-4">
                <div class="mb-4 d-flex flex-wrap justify-content-between align-items-start">
                    <div>
                        <h4 class="user-form-title">Edit User</h4>
                        <p class="user-form-subtitle">Update account details, roles, and management scope for {{ $user->name }}.</p>
                    </div>
                </div>

                @include('systemsetting.users.part.message')

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="row g-3 mb-4">
                        <div class="col-lg-4">
                            <div class="user-section">
                                <div class="user-section-title">Account Details</div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">User Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter name" value="{{ old('name', $user->name) }}">
                                </div>
                                <div class="form-group mb-0">
                                    <label class="form-label" for="email">User Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter email" value="{{ old('email', $user->email) }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="user-section">
                                <div class="user-section-title">Roles</div>
                                <div class="form-group mb-0">
                                    <label class="form-label" for="roles">Assign Roles</label>
                                    <select name="roles[]" id="roles" class="form-control select2" multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="scope-hint">A user can hold multiple roles at the same time.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="user-section h-100">
                                <div class="user-section-title">Management Scope</div>
                                <div class="scope-hint mt-0">
                                    The lowest selected level becomes the user’s management boundary.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="user-section">
                        <div class="user-section-title">Management Scope</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="ghq_id">GHQ Scope</label>
                                <select name="ghq_id" id="ghq_id" class="form-control hierarchy-select">
                                    <option value="">All GHQ</option>
                                    @foreach ($ghqs as $ghq)
                                        <option value="{{ $ghq->id }}" {{ $ghq->id === $user->ghq_id ? 'selected' : '' }}>
                                            {{ $ghq->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="department_id">Department Scope</label>
                                <select name="department_id" id="department_id" class="form-control hierarchy-filter"
                                    data-parent="ghq_id" data-child-key="ghq_id">
                                    <option value="">All Departments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" data-ghq-id="{{ $department->ghq_id }}"
                                            {{ $department->id === $user->department_id ? 'selected' : '' }}>
                                            {{ $department->department }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="directorate_id">Directorate Scope</label>
                                <select name="directorate_id" id="directorate_id" class="form-control hierarchy-filter"
                                    data-parent="ghq_id" data-child-key="ghq_id">
                                    <option value="">All Directorates</option>
                                    @foreach ($directorates as $directorate)
                                        <option value="{{ $directorate->id }}" data-ghq-id="{{ $directorate->ghq_id }}"
                                            {{ $directorate->id === $user->directorate_id ? 'selected' : '' }}>
                                            {{ $directorate->directorate_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="service_hq_id">Service HQ Scope</label>
                                <select name="service_hq_id" id="service_hq_id" class="form-control hierarchy-filter"
                                    data-parent="ghq_id" data-child-key="ghq_id" data-require-parent="true">
                                    <option value="">All Service HQ</option>
                                    @foreach ($serviceHqs as $serviceHq)
                                        <option value="{{ $serviceHq->id }}" data-ghq-id="{{ $serviceHq->ghq_id }}"
                                            {{ $serviceHq->id === $user->service_hq_id ? 'selected' : '' }}>
                                            {{ $serviceHq->service_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="command_hq_id">Command HQ Scope</label>
                                <select name="command_hq_id" id="command_hq_id" class="form-control hierarchy-filter"
                                    data-parent="service_hq_id" data-child-key="service_hq_id" data-require-parent="true">
                                    <option value="">All Commands</option>
                                    @foreach ($commandHqs as $commandHq)
                                        <option value="{{ $commandHq->id }}" data-service-hq-id="{{ $commandHq->service_hq_id }}"
                                            {{ $commandHq->id === $user->command_hq_id ? 'selected' : '' }}>
                                            {{ $commandHq->command_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="unit_id">Unit Scope</label>
                                <select name="unit_id" id="unit_id" class="form-control hierarchy-filter"
                                    data-parent="command_hq_id" data-child-key="command_hq_id" data-require-parent="true">
                                    <option value="">All Units</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" data-command-hq-id="{{ $unit->command_hq_id }}"
                                            {{ $unit->id === $user->unit_id ? 'selected' : '' }}>
                                            {{ $unit->unit_name ?? $unit->unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-user-save">
                            <i class="feather icon-save mr-1"></i>Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

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
