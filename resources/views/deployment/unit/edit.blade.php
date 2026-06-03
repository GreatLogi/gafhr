@extends('admin.admin_master')
@section('admin')
    @php
        $selectedCommand = $unit->commandHq;
        $selectedServiceHq = $selectedCommand?->serviceHq;
        $selectedGhq = $selectedServiceHq?->ghq;
    @endphp

    <style>
        .unit-form-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            box-shadow: 0 12px 28px rgba(47, 59, 74, 0.08);
        }
    </style>

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Edit Unit</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('view-unit') }}">Units</a></li>
                        <li class="breadcrumb-item"><a href="#!">{{ $unit->unit_name ?? $unit->unit }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card unit-form-card">
        <div class="card-body">
            <form action="{{ route('update-unit', $unit->uuid) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="unit_name">Unit Name</label>
                        <input type="text" class="form-control" id="unit_name" name="unit_name"
                            value="{{ old('unit_name', $unit->unit_name ?? $unit->unit) }}">
                        @error('unit_name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($supportsHierarchyChain)
                        <div class="col-md-6">
                            <label class="form-label" for="ghq_id">GHQ</label>
                            <select class="form-control" id="ghq_id" name="ghq_id">
                                <option value="">Select GHQ</option>
                                @foreach ($ghqs as $ghq)
                                    <option value="{{ $ghq->id }}"
                                        {{ (string) old('ghq_id', $selectedGhq?->id) === (string) $ghq->id ? 'selected' : '' }}>
                                        {{ $ghq->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ghq_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="service_hq_id">Service HQ</label>
                            <select class="form-control hierarchy-filter" id="service_hq_id" name="service_hq_id"
                                data-parent="ghq_id" data-child-key="ghq_id" data-require-parent="true">
                                <option value="">Select Service HQ</option>
                                @foreach ($serviceHqs as $serviceHq)
                                    <option value="{{ $serviceHq->id }}" data-ghq-id="{{ $serviceHq->ghq_id }}"
                                        {{ (string) old('service_hq_id', $selectedServiceHq?->id) === (string) $serviceHq->id ? 'selected' : '' }}>
                                        {{ $serviceHq->service_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_hq_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="command_hq_id">Command HQ</label>
                            <select class="form-control hierarchy-filter" id="command_hq_id" name="command_hq_id"
                                data-parent="service_hq_id" data-child-key="service_hq_id" data-require-parent="true">
                                <option value="">Select Command HQ</option>
                                @foreach ($commandHqs as $commandHq)
                                    <option value="{{ $commandHq->id }}" data-service-hq-id="{{ $commandHq->service_hq_id }}"
                                        {{ (string) old('command_hq_id', $selectedCommand?->id) === (string) $commandHq->id ? 'selected' : '' }}>
                                        {{ $commandHq->command_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('command_hq_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <div class="col-12">
                            <div class="alert alert-warning mb-0">
                                Unit hierarchy linking needs the `units.command_hq_id` column. Run the hierarchy migration to enable GHQ, Service HQ, and Command HQ linking here.
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="feather icon-save mr-1"></i>Update Unit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
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
        })();
    </script>
@endsection
