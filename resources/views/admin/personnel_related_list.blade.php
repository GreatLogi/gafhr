@extends(($isModal ?? false) ? 'layouts.modal' : 'admin.admin_master')
@section('admin')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">{{ $title }} for {{ $personnel->surname }} {{ $personnel->first_name }}</h5>
                @if ($isModal ?? false)
                    <button type="button" class="btn btn-sm btn-secondary" onclick="if (window.parent && window.parent.jQuery) { window.parent.jQuery('#personnelRelatedModal').modal('hide'); }">Back to Edit</button>
                @else
                    <a href="{{ route('admin.personnel.edit', $personnel->uuid) }}" class="btn btn-sm btn-secondary">Back to Edit</a>
                @endif
            </div>
            <style>
                .related-form-card {
                    border: 1px solid rgba(0, 0, 0, 0.05);
                    border-radius: 14px;
                    background: #ffffff;
                    box-shadow: 0 10px 24px rgba(88, 60, 40, 0.08);
                }
            </style>
            @php
                $service = strtoupper(str_replace(' ', '', (string) $personnel->arm_of_service));
                $rankDisplay = function ($rank) use ($service) {
                    if (!$rank) {
                        return null;
                    }
                    return match ($service) {
                        'ARMY' => $rank->army_display ?? $rank->rank_code,
                        'NAVY' => $rank->navy_display ?? $rank->rank_code,
                        'AIRFORCE' => $rank->airforce_display ?? $rank->rank_code,
                        default => $rank->rank_code,
                    };
                };
            @endphp
            @if ($title === 'Awards')
                <div class="mb-4 card related-form-card">
                    <div class="card-body">
                        <h6 class="mb-3">Add Award</h6>
                        <form method="POST" action="{{ route('admin.personnel.awards.store', $personnel->uuid) }}">
                            @csrf
                            @if ($isModal ?? false)
                                <input type="hidden" name="modal" value="1">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Award Type</label>
                                    <input type="text" name="award_type" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date Awarded</label>
                                    <input type="date" name="date_awarded" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="description" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Authority Remarks</label>
                                    <input type="text" name="authority_remarks" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Add Award</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($title === 'Courses')
                <div class="mb-4 card related-form-card">
                    <div class="card-body">
                        <h6 class="mb-3">Add Course</h6>
                        <form method="POST" action="{{ route('admin.personnel.courses.store', $personnel->uuid) }}">
                            @csrf
                            @if ($isModal ?? false)
                                <input type="hidden" name="modal" value="1">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Course Name</label>
                                    <input type="text" name="course_name" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Course Type</label>
                                    <input type="text" name="course_type" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Institution</label>
                                    <input type="text" name="institution" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Grading Type</label>
                                    <input type="text" name="grading_type" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Grade</label>
                                    <input type="text" name="grade" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Authority Remarks</label>
                                    <input type="text" name="authority_remarks" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Add Course</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($title === 'Promotions')
                <div class="mb-4 card related-form-card">
                    <div class="card-body">
                        <h6 class="mb-3">Add Promotion</h6>
                        <form method="POST" action="{{ route('admin.personnel.promotions.store', $personnel->uuid) }}">
                            @csrf
                            @if ($isModal ?? false)
                                <input type="hidden" name="modal" value="1">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Previous Rank</label>
                                    <select class="form-select" name="previous_rank_code" required>
                                        @foreach ($ranks as $rank)
                                            <option value="{{ $rank->rank_code }}">
                                                {{ $rankDisplay($rank) ?? $rank->rank_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Promoted To</label>
                                    <select class="form-select" name="promoted_to_rank_code" required>
                                        @foreach ($ranks as $rank)
                                            <option value="{{ $rank->rank_code }}">
                                                {{ $rankDisplay($rank) ?? $rank->rank_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Promotion Type</label>
                                    <input type="text" name="promotion_type" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Effective Date</label>
                                    <input type="date" name="effective_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Seniority Date</label>
                                    <input type="date" name="seniority_date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Authority Remarks</label>
                                    <input type="text" name="authority_remarks" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Add Promotion</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($title === 'Documents')
                <div class="mb-4 card related-form-card">
                    <div class="card-body">
                        <h6 class="mb-3">Add Document</h6>
                        <form method="POST" action="{{ route('admin.personnel.documents.store', $personnel->uuid) }}">
                            @csrf
                            @if ($isModal ?? false)
                                <input type="hidden" name="modal" value="1">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Document Name</label>
                                    <input type="text" name="document_name" class="form-control" required>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Add Document</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($title === 'Family')
                <div class="mb-4 card related-form-card">
                    <div class="card-body">
                        <h6 class="mb-3">Add Family</h6>
                        <form method="POST" action="{{ route('admin.personnel.family.store', $personnel->uuid) }}">
                            @csrf
                            @if ($isModal ?? false)
                                <input type="hidden" name="modal" value="1">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Relation</label>
                                    <input type="text" name="family_relation" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Sex</label>
                                    <select class="form-select" name="sex">
                                        <option value="">Select</option>
                                        <option value="M">M</option>
                                        <option value="F">F</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nationality</label>
                                    <input type="text" name="nationality" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status</label>
                                    <input type="text" name="status" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Place of Birth</label>
                                    <input type="text" name="place_of_birth" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">House Address</label>
                                    <input type="text" name="house_address" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Authority Remarks</label>
                                    <input type="text" name="authority_remarks" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Add Family</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($title === 'Next of Kin')
                <div class="mb-4 card related-form-card">
                    <div class="card-body">
                        <h6 class="mb-3">Add Next of Kin</h6>
                        <form method="POST" action="{{ route('admin.personnel.next_of_kin.store', $personnel->uuid) }}">
                            @csrf
                            @if ($isModal ?? false)
                                <input type="hidden" name="modal" value="1">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Relation</label>
                                    <input type="text" name="relation" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nationality</label>
                                    <input type="text" name="nationality" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Place of Birth</label>
                                    <input type="text" name="place_of_birth" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mobile</label>
                                    <input type="text" name="mobile" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Authority Remarks</label>
                                    <input type="text" name="authority_remarks" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Add Next of Kin</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($title === 'Posts')
                <div class="mb-4 card related-form-card">
                    <div class="card-body">
                        <h6 class="mb-3">Add Post</h6>
                        <form method="POST" action="{{ route('admin.personnel.posts.store', $personnel->uuid) }}">
                            @csrf
                            @if ($isModal ?? false)
                                <input type="hidden" name="modal" value="1">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Post From</label>
                                    <select class="form-select" name="post_from">
                                        <option value="">Select</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->unit ?? $unit->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Post To</label>
                                    <select class="form-select" name="post_to">
                                        <option value="">Select</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->unit ?? $unit->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Post Type</label>
                                    <input type="text" name="post_type" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">WEF Date</label>
                                    <input type="date" name="wef_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Appointment</label>
                                    <select class="form-select" name="appointment_id">
                                        <option value="">Select</option>
                                        @foreach ($appointments as $appointment)
                                            <option value="{{ $appointment->id }}">{{ $appointment->appointment ?? $appointment->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Appointment Type</label>
                                    <input type="text" name="appointment_type" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Authority Remarks</label>
                                    <input type="text" name="authority_remarks" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Add Post</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($title === 'Remarks')
                <div class="mb-4 card related-form-card">
                    <div class="card-body">
                        <h6 class="mb-3">Add Remark</h6>
                        <form method="POST" action="{{ route('admin.personnel.remarks.store', $personnel->uuid) }}">
                            @csrf
                            @if ($isModal ?? false)
                                <input type="hidden" name="modal" value="1">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-10">
                                    <label class="form-label">Remark</label>
                                    <input type="text" name="remark" class="form-control" required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif ($title === 'Interviews')
                <div class="mb-4 card related-form-card">
                    <div class="card-body">
                        <h6 class="mb-3">Add Interview</h6>
                        <form method="POST" action="{{ route('admin.personnel.interviews.store', $personnel->uuid) }}">
                            @csrf
                            @if ($isModal ?? false)
                                <input type="hidden" name="modal" value="1">
                            @endif
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Interview Date</label>
                                    <input type="date" name="interview_date" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Reason</label>
                                    <input type="text" name="reason" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Authority Remarks</label>
                                    <input type="text" name="authority_remarks" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Add Interview</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Details</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($title === 'Promotions')
                                        {{ $rankDisplay($item->previous_rank) ?? $item->previous_rank_code ?? 'N/A' }}
                                        ->
                                        {{ $rankDisplay($item->promoted_rank) ?? $item->promoted_to_rank_code ?? 'N/A' }}
                                    @elseif ($title === 'Family')
                                        {{ $item->full_name ?? $item->name ?? 'N/A' }}
                                        @if (!empty($item->family_relation))
                                            ({{ $item->family_relation }})
                                        @endif
                                    @elseif ($title === 'Next of Kin')
                                        {{ $item->full_name ?? 'N/A' }}
                                        @if (!empty($item->relation))
                                            ({{ $item->relation }})
                                        @endif
                                    @elseif ($title === 'Posts')
                                        {{ $item->posted_from->unit ?? $item->post_from ?? 'N/A' }}
                                        ->
                                        {{ $item->posted_to->unit ?? $item->post_to ?? 'N/A' }}
                                    @elseif ($title === 'Remarks')
                                        {{ $item->remark ?? 'N/A' }}
                                    @else
                                        {{ $item->name ?? $item->title ?? $item->course_name ?? $item->award ?? $item->remarks ?? $item->unit_id ?? $item->id }}
                                    @endif
                                </td>
                                <td>{{ $item->created_at ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
