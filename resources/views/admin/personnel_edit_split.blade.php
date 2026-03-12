@extends('admin.admin_master')
@section('admin')
    <style>
        :root {
            --surface-bg: #f5f6f8;
            --card-bg: #ffffff;
            --input-bg: #ffffff;
            --border-soft: #dfe3e8;
            --text-main: #2f3b4a;
        }

        .form-page {
            background: var(--surface-bg);
            padding: 18px;
            border-radius: 16px;
        }

        .form-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            background: var(--card-bg);
            box-shadow: 0 12px 28px rgba(88, 60, 40, 0.08);
        }

        .form-title {
            color: var(--text-main);
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .form-label {
            color: var(--text-main);
            font-weight: 600;
        }

        .form-control,
        .form-select,
        textarea.form-control {
            border-radius: 10px;
            border: 1px solid var(--border-soft);
            background-color: var(--input-bg);
        }

        .form-control:focus,
        .form-select:focus,
        textarea.form-control:focus {
            border-color: #8aa7c5;
            box-shadow: 0 0 0 0.2rem rgba(138, 167, 197, 0.2);
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
                <h5 class="mb-3 form-title">Edit Personnel</h5>
                <div class="mb-3 d-flex flex-wrap gap-2">
                    <a class="btn btn-outline-primary btn-sm open-related-modal" href="{{ route('admin.personnel.awards', $personnel->uuid) }}">Awards</a>
                    <a class="btn btn-outline-primary btn-sm open-related-modal" href="{{ route('admin.personnel.courses', $personnel->uuid) }}">Courses</a>
                    <a class="btn btn-outline-primary btn-sm open-related-modal" href="{{ route('admin.personnel.promotions', $personnel->uuid) }}">Promotions</a>
                    <a class="btn btn-outline-primary btn-sm open-related-modal" href="{{ route('admin.personnel.documents', $personnel->uuid) }}">Documents</a>
                    <a class="btn btn-outline-primary btn-sm open-related-modal" href="{{ route('admin.personnel.family', $personnel->uuid) }}">Family</a>
                    <a class="btn btn-outline-primary btn-sm open-related-modal" href="{{ route('admin.personnel.next_of_kin', $personnel->uuid) }}">Next of Kin</a>
                    <a class="btn btn-outline-primary btn-sm open-related-modal" href="{{ route('admin.personnel.posts', $personnel->uuid) }}">Posts</a>
                    <a class="btn btn-outline-primary btn-sm open-related-modal" href="{{ route('admin.personnel.remarks', $personnel->uuid) }}">Remarks</a>
                    <a class="btn btn-outline-primary btn-sm open-related-modal" href="{{ route('admin.personnel.interviews', $personnel->uuid) }}">Interviews</a>
                </div>
                <form method="POST" action="{{ route('admin.personnel.update', $personnel->uuid) }}"
                    enctype="multipart/form-data">
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
                                        <label class="form-label" for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
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
                                                    src="{{ $personnel->personnel_image ? asset($personnel->personnel_image) : asset('img/avatar.jpg') }}"
                                                    alt="Personnel Photo" class="img-fluid rounded" style="max-height: 200px;">
                                            </div>
                                            <input type="file" class="form-control" id="{{ $field }}" name="{{ $field }}"
                                                accept="image/*">
                                        @else
                                            <input type="{{ $type }}" class="form-control" id="{{ $field }}"
                                                name="{{ $field }}" value="{{ old($field, $personnel->{$field}) }}">
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
                                        <label class="form-label" for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
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
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="ARMY" {{ $personnel->arm_of_service === 'ARMY' ? 'selected' : '' }}>ARMY</option>
                                                <option value="NAVY" {{ $personnel->arm_of_service === 'NAVY' ? 'selected' : '' }}>NAVY</option>
                                                <option value="AIRFORCE" {{ $personnel->arm_of_service === 'AIRFORCE' ? 'selected' : '' }}>AIRFORCE</option>
                                            </select>
                                        @elseif ($field === 'sex')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="M" {{ $personnel->sex === 'M' ? 'selected' : '' }}>M</option>
                                                <option value="F" {{ $personnel->sex === 'F' ? 'selected' : '' }}>F</option>
                                            </select>
                                        @elseif ($field === 'marital_status')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="SINGLE" {{ $personnel->marital_status === 'SINGLE' ? 'selected' : '' }}>SINGLE</option>
                                                <option value="MARRIED" {{ $personnel->marital_status === 'MARRIED' ? 'selected' : '' }}>MARRIED</option>
                                                <option value="DIVORCED" {{ $personnel->marital_status === 'DIVORCED' ? 'selected' : '' }}>DIVORCED</option>
                                            </select>
                                        @elseif ($field === 'religion')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="CHRISTIAN" {{ $personnel->religion === 'CHRISTIAN' ? 'selected' : '' }}>CHRISTIAN</option>
                                                <option value="MUSLIM" {{ $personnel->religion === 'MUSLIM' ? 'selected' : '' }}>MUSLIM</option>
                                            </select>
                                        @elseif ($field === 'appointment_type')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="ACTING" {{ $personnel->appointment_type === 'ACTING' ? 'selected' : '' }}>ACTING</option>
                                                <option value="SUBSTANTIVE" {{ $personnel->appointment_type === 'SUBSTANTIVE' ? 'selected' : '' }}>SUBSTANTIVE</option>
                                            </select>
                                        @elseif ($field === 'unit_id')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ $unit->id === $personnel->unit_id ? 'selected' : '' }}>
                                                        {{ $unit->unit ?? $unit->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'attached_unit')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ $unit->id === $personnel->attached_unit ? 'selected' : '' }}>
                                                        {{ $unit->unit ?? $unit->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'branch_id')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ $branch->id === $personnel->branch_id ? 'selected' : '' }}>
                                                        {{ $branch->branch ?? $branch->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'trade_id')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($trades as $trade)
                                                    <option value="{{ $trade->id }}" {{ $trade->id === $personnel->trade_id ? 'selected' : '' }}>
                                                        {{ $trade->trade ?? $trade->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'present_rank')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($ranks as $rank)
                                                    <option value="{{ $rank->rank_code }}" {{ $rank->rank_code === $personnel->present_rank ? 'selected' : '' }}
                                                        data-army="{{ $rank->army_display }}"
                                                        data-navy="{{ $rank->navy_display }}"
                                                        data-airforce="{{ $rank->airforce_display }}">
                                                        {{ $rank->army_display ?? $rank->navy_display ?? $rank->airforce_display ?? 'RANK' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'rank_on_commission')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($ranks as $rank)
                                                    <option value="{{ $rank->rank_code }}" {{ $rank->rank_code === $personnel->rank_on_commission ? 'selected' : '' }}
                                                        data-army="{{ $rank->army_display }}"
                                                        data-navy="{{ $rank->navy_display }}"
                                                        data-airforce="{{ $rank->airforce_display }}">
                                                        {{ $rank->army_display ?? $rank->navy_display ?? $rank->airforce_display ?? 'RANK' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'intake')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                <option value="RCC" {{ $personnel->intake === 'RCC' ? 'selected' : '' }}>RCC</option>
                                                <option value="SSC" {{ $personnel->intake === 'SSC' ? 'selected' : '' }}>SSC</option>
                                                <option value="SSD" {{ $personnel->intake === 'SSD' ? 'selected' : '' }}>SSD</option>
                                            </select>
                                        @elseif ($field === 'intake_number')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @for ($i = 1; $i <= 100; $i++)
                                                    @php($val = str_pad((string) $i, 2, '0', STR_PAD_LEFT))
                                                    <option value="{{ $val }}" {{ (string) $personnel->intake_number === $val ? 'selected' : '' }}>{{ $val }}</option>
                                                @endfor
                                            </select>
                                        @elseif ($field === 'hometown_region')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}" {{ $region->id === $personnel->hometown_region ? 'selected' : '' }}>
                                                        {{ $region->region ?? $region->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'hometown_district')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                            </select>
                                        @elseif ($field === 'tribe_id')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($tribes as $tribe)
                                                    <option value="{{ $tribe->id }}" {{ $tribe->id === $personnel->tribe_id ? 'selected' : '' }}>
                                                        {{ $tribe->name ?? $tribe->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'denomination_id')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($denominations as $denomination)
                                                    <option value="{{ $denomination->id }}" {{ $denomination->id === $personnel->denomination_id ? 'selected' : '' }}>
                                                        {{ $denomination->denomination ?? $denomination->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'appointment_id')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($appointments as $appointment)
                                                    <option value="{{ $appointment->id }}" {{ $appointment->id === $personnel->appointment_id ? 'selected' : '' }}>
                                                        {{ $appointment->appointment ?? $appointment->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'profession_id')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}">
                                                <option value="">Select</option>
                                                @foreach ($professions as $profession)
                                                    <option value="{{ $profession->id }}" {{ $profession->id === $personnel->profession_id ? 'selected' : '' }}>
                                                        {{ $profession->name ?? $profession->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif ($field === 'languages_spoken')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}[]" multiple>
                                                @foreach (['AKAN (TWI)','FANTE','EWE','GA','DAGBANI','HAUSA','DAGARE','GONJA','NZEMA','GUAN','DANGME','KASEM','MAMPRULI','KUSAAL','BULI','SISSALA','FRAFRA'] as $lang)
                                                    <option value="{{ $lang }}" {{ in_array($lang, (array) $personnel->languages_spoken) ? 'selected' : '' }}>{{ $lang }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Hold Ctrl/Command to select multiple.</small>
                                        @elseif ($field === 'hobbies')
                                            <select class="form-select form-control" id="{{ $field }}" name="{{ $field }}[]" multiple>
                                                @foreach (['FOOTBALL','READING','MUSIC','TRAVELING','COOKING','SWIMMING','ATHLETICS','BASKETBALL','VOLLEYBALL','HIKING','PHOTOGRAPHY','GAMING','FISHING','WRITING','DANCING','CYCLING','CHESS'] as $hob)
                                                    <option value="{{ $hob }}" {{ in_array($hob, (array) $personnel->hobbies) ? 'selected' : '' }}>{{ $hob }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Hold Ctrl/Command to select multiple.</small>
                                        @else
                                            <input type="{{ $type }}" class="form-control" id="{{ $field }}"
                                                name="{{ $field }}" value="{{ old($field, $personnel->{$field}) }}">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="personnelRelatedModal" tabindex="-1" role="dialog" aria-labelledby="personnelRelatedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="personnelRelatedModalLabel">Update Personnel Attributes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0" style="height: 80vh;">
                    <iframe id="personnelRelatedFrame" src="about:blank" style="width: 100%; height: 100%; border: 0;"
                        title="Personnel Related Form"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const regions = @json($regions ?? []);
            const regionSelect = document.getElementById('hometown_region');
            const districtSelect = document.getElementById('hometown_district');
            const imageInput = document.getElementById('personnel_image');
            const imagePreview = document.getElementById('personnelImagePreview');
            const serviceSelect = document.getElementById('arm_of_service');
            const rankSelect = document.getElementById('present_rank');
            const rankCommissionSelect = document.getElementById('rank_on_commission');

            const regionMap = new Map();
            regions.forEach((r) => {
                regionMap.set(String(r.id), r.districts || []);
            });

            if (regionSelect && districtSelect) {
                regionSelect.addEventListener('change', function () {
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
            }

            const updateRankOptions = function () {
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
                imageInput.addEventListener('change', function () {
                    const file = this.files && this.files[0];
                    if (!file) {
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            }

            document.addEventListener('click', function (e) {
                const trigger = e.target.closest('.open-related-modal');
                if (!trigger) {
                    return;
                }

                e.preventDefault();
                const baseUrl = trigger.getAttribute('href');
                const modalUrl = baseUrl.indexOf('?') >= 0 ? `${baseUrl}&modal=1` : `${baseUrl}?modal=1`;
                const frame = document.getElementById('personnelRelatedFrame');
                if (frame) {
                    frame.src = modalUrl;
                }

                if (window.jQuery) {
                    window.jQuery('#personnelRelatedModal').modal('show');
                } else {
                    window.location.href = modalUrl;
                }
            });

            const relatedModal = document.getElementById('personnelRelatedModal');
            if (relatedModal) {
                relatedModal.addEventListener('hidden.bs.modal', function () {
                    const frame = document.getElementById('personnelRelatedFrame');
                    if (frame) {
                        frame.src = 'about:blank';
                    }
                });
            }

            window.addEventListener('load', function () {
                if (!window.jQuery) {
                    return;
                }
                window.jQuery('#personnelRelatedModal').on('hidden.bs.modal', function () {
                    const frame = document.getElementById('personnelRelatedFrame');
                    if (frame) {
                        frame.src = 'about:blank';
                    }
                });
            });
        })();
    </script>
@endsection
