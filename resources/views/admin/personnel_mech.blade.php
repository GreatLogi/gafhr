@extends('admin.admin_master')
@section('admin')
    <style>
        :root {
            --gold-50: #fff9ec;
            --gold-100: #fbeccf;
            --gold-200: #f5dcae;
            --gold-300: #e7c88a;
            --brown-200: #d9c3b2;
            --brown-400: #b08d74;
            --brown-700: #6d4f3a;
        }

        .form-page {
            background: linear-gradient(135deg, var(--gold-50) 0%, #ffffff 45%, var(--gold-100) 100%);
            padding: 18px;
            border-radius: 16px;
        }

        .form-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            background: linear-gradient(180deg, #ffffff 0%, #fff7e8 100%);
            box-shadow: 0 12px 28px rgba(88, 60, 40, 0.08);
        }

        .form-title {
            color: var(--brown-700);
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .form-label {
            color: var(--brown-700);
            font-weight: 600;
        }

        .form-control,
        .form-select,
        textarea.form-control {
            border-radius: 10px;
            border: 1px solid rgba(176, 141, 116, 0.35);
            background-color: #fffdf7;
        }

        .form-control:focus,
        .form-select:focus,
        textarea.form-control:focus {
            border-color: var(--gold-300);
            box-shadow: 0 0 0 0.2rem rgba(231, 200, 138, 0.35);
        }

        .btn-primary {
            background: linear-gradient(135deg, #d9b26a 0%, #b8865a 100%);
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #cfa45c 0%, #a6774f 100%);
        }
    </style>

    <div class="form-page">
        <div class="card form-card">
            <div class="card-body">
                <h5 class="mb-3 form-title">Add Personnel</h5>
                <form method="POST" action="{{ route('admin.personnel.store') }}" enctype="multipart/form-data">
                    @csrf
                    @php
                        $skipFields = ['seniority_roll', 'initials', 'age', 'rank_code'];
                        $leftFields = ['personnel_image', 'service_no', 'surname', 'first_name'];
                    @endphp
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="row g-3">
                                @foreach ($leftFields as $field)
                                    @if (!in_array($field, $fields))
                                        @continue
                                    @endif
                                    <div class="col-12">
                                        <label class="form-label"
                                            for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                        @php
                                            $type = 'text';
                                            if (str_contains($field, 'date')) {
                                                $type = 'date';
                                            } elseif (str_contains($field, 'email')) {
                                                $type = 'email';
                                            }
                                        @endphp
                                        @if ($field === 'personnel_image')
                                            <div class="mb-2">
                                                <img id="personnelImagePreview"
                                                    src="{{ asset('assets/images/defaultprofile.jpg') }}"
                                                    alt="Personnel Photo" class="rounded img-fluid"
                                                    style="max-height: 200px;">
                                            </div>
                                            <input type="file" class="form-control" id="{{ $field }}"
                                                name="{{ $field }}" accept="image/*">
                                        @else
                                            <input type="{{ $type }}" class="form-control" id="{{ $field }}"
                                                name="{{ $field }}" value="{{ old($field) }}">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row g-3">
                                @foreach ($fields as $field)
                                    @if (in_array($field, $skipFields) || in_array($field, $leftFields))
                                        @continue
                                    @endif
                                    <div class="col-md-4">
                                        <label class="form-label"
                                            for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                        @php
                                            $type = 'text';
                                            if (str_contains($field, 'date')) {
                                                $type = 'date';
                                            } elseif (str_contains($field, 'email')) {
                                                $type = 'email';
                                            } elseif (str_contains($field, 'phone')) {
                                                $type = 'text';
                                            }
                                        @endphp
                                        @if ($field === 'arm_of_service')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="ARMY">ARMY</option>
                                                <option value="NAVY">NAVY</option>
                                                <option value="AIRFORCE">AIRFORCE</option>
                                            </select>
                                        @elseif ($field === 'sex')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="M">M</option>
                                                <option value="F">F</option>
                                            </select>
                                        @elseif ($field === 'marital_status')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="SINGLE">SINGLE</option>
                                                <option value="MARRIED">MARRIED</option>
                                                <option value="DIVORCED">DIVORCED</option>
                                            </select>
                                        @elseif ($field === 'religion')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="CHRISTIAN">CHRISTIAN</option>
                                                <option value="MUSLIM">MUSLIM</option>
                                            </select>
                                        @elseif ($field === 'appointment_type')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="ACTING">ACTING</option>
                                                <option value="SUBSTANTIVE">SUBSTANTIVE</option>
                                            </select>
                                        @elseif ($field === 'unit_id')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->unit ?? $unit->id }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'attached_unit')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->unit ?? $unit->id }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'branch_id')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}">
                                                        {{ $branch->branch ?? $branch->id }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'trade_id')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($trades as $trade)
                                                    <option value="{{ $trade->id }}">{{ $trade->trade ?? $trade->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'present_rank')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($ranks as $rank)
                                                    <option value="{{ $rank->rank_code }}"
                                                        data-army="{{ $rank->army_display }}"
                                                        data-navy="{{ $rank->navy_display }}"
                                                        data-airforce="{{ $rank->airforce_display }}">
                                                        {{ $rank->army_display ?? $rank->navy_display ?? $rank->airforce_display ?? 'RANK' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'rank_on_commission')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($ranks as $rank)
                                                    <option value="{{ $rank->rank_code }}"
                                                        data-army="{{ $rank->army_display }}"
                                                        data-navy="{{ $rank->navy_display }}"
                                                        data-airforce="{{ $rank->airforce_display }}">
                                                        {{ $rank->army_display ?? $rank->navy_display ?? $rank->airforce_display ?? 'RANK' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'intake_number')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @for ($i = 1; $i <= 100; $i++)
                                                    <option value="{{ str_pad((string) $i, 2, '0', STR_PAD_LEFT) }}">
                                                        {{ str_pad((string) $i, 2, '0', STR_PAD_LEFT) }}
                                                    </option>
                                                @endfor
                                            </select>
                                        @elseif ($field === 'intake')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="RCC">RCC</option>
                                                <option value="SSC">SSC</option>
                                                <option value="SSD">SSD</option>
                                            </select>
                                        @elseif ($field === 'hometown_region')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}">
                                                        {{ $region->region ?? $region->id }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'hometown_district')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                            </select>
                                        @elseif ($field === 'tribe_id')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($tribes as $tribe)
                                                    <option value="{{ $tribe->id }}">{{ $tribe->name ?? $tribe->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'denomination_id')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($denominations as $denomination)
                                                    <option value="{{ $denomination->id }}">
                                                        {{ $denomination->denomination ?? $denomination->id }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'appointment_id')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($appointments as $appointment)
                                                    <option value="{{ $appointment->id }}">
                                                        {{ $appointment->appointment ?? $appointment->id }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'profession_id')
                                            <select class="form-select form-control" id="{{ $field }}"
                                                name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($professions as $profession)
                                                    <option value="{{ $profession->id }}">
                                                        {{ $profession->name ?? $profession->id }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'languages_spoken')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}[]" multiple>
                                                <option value="AKAN (TWI)">AKAN (TWI)</option>
                                                <option value="FANTE">FANTE</option>
                                                <option value="EWE">EWE</option>
                                                <option value="GA">GA</option>
                                                <option value="DAGBANI">DAGBANI</option>
                                                <option value="HAUSA">HAUSA</option>
                                                <option value="DAGARE">DAGARE</option>
                                                <option value="GONJA">GONJA</option>
                                                <option value="NZEMA">NZEMA</option>
                                                <option value="GUAN">GUAN</option>
                                                <option value="DANGME">DANGME</option>
                                                <option value="KASEM">KASEM</option>
                                                <option value="MAMPRULI">MAMPRULI</option>
                                                <option value="KUSAAL">KUSAAL</option>
                                                <option value="BULI">BULI</option>
                                                <option value="SISSALA">SISSALA</option>
                                                <option value="FRAFRA">FRAFRA</option>
                                            </select>
                                            <small class="text-muted">Hold Ctrl/Command to select multiple.</small>
                                        @elseif ($field === 'hobbies')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}[]" multiple>
                                                <option value="FOOTBALL">FOOTBALL</option>
                                                <option value="READING">READING</option>
                                                <option value="MUSIC">MUSIC</option>
                                                <option value="TRAVELING">TRAVELING</option>
                                                <option value="COOKING">COOKING</option>
                                                <option value="SWIMMING">SWIMMING</option>
                                                <option value="ATHLETICS">ATHLETICS</option>
                                                <option value="BASKETBALL">BASKETBALL</option>
                                                <option value="VOLLEYBALL">VOLLEYBALL</option>
                                                <option value="HIKING">HIKING</option>
                                                <option value="PHOTOGRAPHY">PHOTOGRAPHY</option>
                                                <option value="GAMING">GAMING</option>
                                                <option value="FISHING">FISHING</option>
                                                <option value="WRITING">WRITING</option>
                                                <option value="DANCING">DANCING</option>
                                                <option value="CYCLING">CYCLING</option>
                                                <option value="CHESS">CHESS</option>
                                            </select>
                                            <small class="text-muted">Hold Ctrl/Command to select multiple.</small>
                                        @else
                                            <input type="{{ $type }}" class="form-control"
                                                id="{{ $field }}" name="{{ $field }}"
                                                value="{{ old($field) }}">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save Personnel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const regions = @json($regions ?? []);
            const regionSelect = document.getElementById('hometown_region');
            const districtSelect = document.getElementById('hometown_district');
            const imageInput = document.getElementById('personnel_image');
            const imagePreview = document.getElementById('personnelImagePreview');
            const serviceSelect = document.getElementById('arm_of_service');
            const rankSelect = document.getElementById('present_rank');
            const rankCommissionSelect = document.getElementById('rank_on_commission');

            if (!regionSelect || !districtSelect) {
                return;
            }

            const regionMap = new Map();
            regions.forEach((r) => {
                regionMap.set(String(r.id), r.districts || []);
            });

            regionSelect.addEventListener('change', function() {
                const selected = String(this.value || '');
                const districts = regionMap.get(selected) || [];

                districtSelect.innerHTML = '<option value="">Select</option>';
                districts.forEach((d) => {
                    const opt = document.createElement('option');
                    opt.value = d;
                    opt.textContent = d;
                    districtSelect.appendChild(opt);
                });
            });

            const updateRankOptions = function() {
                if (!serviceSelect) {
                    return;
                }
                const service = String(serviceSelect.value || '').toLowerCase();
                [rankSelect, rankCommissionSelect].forEach((selectEl) => {
                    if (!selectEl) {
                        return;
                    }
                    const opts = selectEl.querySelectorAll('option[data-army]');
                    opts.forEach((opt) => {
                        const label = opt.getAttribute(`data-${service}`) || opt.getAttribute('data-army') || 'RANK';
                        opt.textContent = label || 'RANK';
                    });
                });
            };

            if (serviceSelect) {
                serviceSelect.addEventListener('change', updateRankOptions);
                updateRankOptions();
            }

            if (imageInput && imagePreview) {
                imageInput.addEventListener('change', function() {
                    const file = this.files && this.files[0];
                    if (!file) {
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            }
        })();
    </script>
@endsection
