<?php

namespace App\Http\Controllers;

use App\Imports\PersonnelImport;
use App\Models\Personnel;
use App\Models\Region;
use App\Models\Tribe;
use App\Models\Denomination;
use App\Models\Appointment;
use App\Models\Profession;
use App\Models\Branch;
use App\Models\Trade;
use App\Models\rank;
use App\Models\Service;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class personnelcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $pers = Personnel::latest()->get();
        return view('deployment.personnel.index');
    }

    public function create()
    {
        $unit = Unit::all();
        $ranks = rank::all();
        $service = Service::all();

        return view('deployment.personnel.create', compact('unit', 'ranks', 'service'));
    }

    public function adminCreate()
    {
        $fields = (new Personnel())->getFillable();
        $units = Unit::all();
        $ranks = rank::all();
        $regions = Region::all();
        $tribes = Tribe::all();
        $denominations = Denomination::all();
        $appointments = Appointment::all();
        $professions = Profession::all();
        $branches = Branch::all();
        $trades = Trade::all();

        return view('admin.personnel_mech', compact(
            'fields',
            'units',
            'ranks',
            'regions',
            'tribes',
            'denominations',
            'appointments',
            'professions',
            'branches',
            'trades'
        ));
    }

    public function adminStore(Request $request)
    {
        $fields = (new Personnel())->getFillable();
        $request->validate([
            'service_no' => 'required',
            'surname' => 'required',
            'first_name' => 'required',
            'arm_of_service' => 'required',
            'present_rank' => 'required',
            'unit_id' => 'required',
            'sex' => 'required',
            'personnel_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
        $data = $request->only($fields);

        // Normalize array-cast fields if comma-separated text is provided
        foreach (['languages_spoken', 'hobbies'] as $arrayField) {
            if (isset($data[$arrayField]) && is_string($data[$arrayField])) {
                $value = trim($data[$arrayField]);
                if ($value !== '' && str_starts_with($value, '[') === false) {
                    $data[$arrayField] = array_values(array_filter(array_map('trim', explode(',', $value))));
                }
            }
        }

        if ($request->hasFile('personnel_image')) {
            $image = $request->file('personnel_image');
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('upload/personnel/' . $nameGen);
            $data['personnel_image'] = 'upload/personnel/' . $nameGen;
        }

        $personnel = new Personnel();
        $personnel->fill($data);
        if (Auth::check()) {
            $personnel->created_by = Auth::id();
        }
        $personnel->save();

        $notification = [
            'message' => 'Personnel Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('personal-view')->with($notification);
    }

    public function adminEdit($uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
        $fields = (new Personnel())->getFillable();
        $units = Unit::all();
        $ranks = rank::all();
        $regions = Region::all();
        $tribes = Tribe::all();
        $denominations = Denomination::all();
        $appointments = Appointment::all();
        $professions = Profession::all();
        $branches = Branch::all();
        $trades = Trade::all();

        return view('admin.personnel_edit_split', compact(
            'personnel',
            'fields',
            'units',
            'ranks',
            'regions',
            'tribes',
            'denominations',
            'appointments',
            'professions',
            'branches',
            'trades'
        ));
    }

    public function adminUpdate(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'service_no' => 'required',
            'surname' => 'required',
            'first_name' => 'required',
            'arm_of_service' => 'required',
            'present_rank' => 'required',
            'unit_id' => 'required',
            'sex' => 'required',
            'personnel_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $fields = (new Personnel())->getFillable();
        $data = $request->only($fields);

        foreach (['languages_spoken', 'hobbies'] as $arrayField) {
            if (isset($data[$arrayField]) && is_string($data[$arrayField])) {
                $value = trim($data[$arrayField]);
                if ($value !== '' && str_starts_with($value, '[') === false) {
                    $data[$arrayField] = array_values(array_filter(array_map('trim', explode(',', $value))));
                }
            }
        }

        if ($request->hasFile('personnel_image')) {
            $image = $request->file('personnel_image');
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('upload/personnel/' . $nameGen);
            $data['personnel_image'] = 'upload/personnel/' . $nameGen;
        }

        $personnel->update($data);

        return redirect()->route('record-manager')->with([
            'message' => 'Personnel updated successfully',
            'alert-type' => 'success',
        ]);
    }

    private function modalRouteParams(Request $request, string $uuid): array
    {
        if ($request->boolean('modal')) {
            return ['uuid' => $uuid, 'modal' => 1];
        }

        return ['uuid' => $uuid];
    }

    private function relatedView($uuid, string $relation, string $title, bool $isModal = false)
    {
        $personnel = Personnel::where('uuid', $uuid)->with($relation)->firstOrFail();
        $items = $personnel->{$relation};
        if ($items instanceof \Illuminate\Database\Eloquent\Model) {
            $items = collect([$items]);
        } elseif (is_null($items) || $items === false) {
            $items = collect();
        }

        return view('admin.personnel_related_list', [
            'title' => $title,
            'personnel' => $personnel,
            'items' => $items,
            'units' => Unit::all(),
            'ranks' => rank::all(),
            'appointments' => Appointment::all(),
            'isModal' => $isModal,
        ]);
    }

    public function awards(Request $request, $uuid)
    {
        return $this->relatedView($uuid, 'awards', 'Awards', $request->boolean('modal'));
    }

    public function storeAward(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'award_type' => 'required|string',
            'description' => 'nullable|string',
            'date_awarded' => 'nullable|date',
            'authority_remarks' => 'nullable|string',
        ]);

        $personnel->awards()->create([
            'award_type' => $request->award_type,
            'description' => $request->description,
            'date_awarded' => $request->date_awarded,
            'authority_remarks' => $request->authority_remarks,
        ]);

        return redirect()->route('admin.personnel.awards', $this->modalRouteParams($request, $personnel->uuid))->with([
            'message' => 'Award added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storeCourse(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
        $request->validate([
            'course_name' => 'required|string',
            'course_type' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'location' => 'nullable|string',
            'grading_type' => 'nullable|string',
            'grade' => 'nullable|string',
            'institution' => 'nullable|string',
            'authority_remarks' => 'nullable|string',
        ]);
        $personnel->courses()->create($request->only([
            'course_name',
            'course_type',
            'start_date',
            'end_date',
            'location',
            'grading_type',
            'grade',
            'institution',
            'authority_remarks',
        ]));

        return redirect()->route('admin.personnel.courses', $this->modalRouteParams($request, $personnel->uuid))->with([
            'message' => 'Course added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storePromotion(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
        $request->validate([
            'previous_rank_code' => 'required|string',
            'promoted_to_rank_code' => 'required|string',
            'promotion_type' => 'nullable|string',
            'effective_date' => 'nullable|date',
            'seniority_date' => 'nullable|date',
            'authority_remarks' => 'nullable|string',
        ]);
        $personnel->promotions()->create($request->only([
            'previous_rank_code',
            'promoted_to_rank_code',
            'promotion_type',
            'effective_date',
            'seniority_date',
            'authority_remarks',
        ]));

        return redirect()->route('admin.personnel.promotions', $this->modalRouteParams($request, $personnel->uuid))->with([
            'message' => 'Promotion added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storeDocument(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
        $request->validate([
            'document_name' => 'required|string',
        ]);
        $personnel->documents()->create($request->only(['document_name']));

        return redirect()->route('admin.personnel.documents', $this->modalRouteParams($request, $personnel->uuid))->with([
            'message' => 'Document added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storeFamily(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
        $request->validate([
            'full_name' => 'required|string',
            'family_relation' => 'nullable|string',
            'sex' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string',
            'status' => 'nullable|string',
            'place_of_birth' => 'nullable|string',
            'house_address' => 'nullable|string',
            'authority_remarks' => 'nullable|string',
        ]);
        $personnel->family()->create($request->only([
            'full_name',
            'family_relation',
            'sex',
            'date_of_birth',
            'nationality',
            'status',
            'place_of_birth',
            'house_address',
            'authority_remarks',
        ]));

        return redirect()->route('admin.personnel.family', $this->modalRouteParams($request, $personnel->uuid))->with([
            'message' => 'Family record added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storeNextOfKin(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
        $request->validate([
            'full_name' => 'required|string',
            'relation' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string',
            'place_of_birth' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'mobile' => 'nullable|string',
            'address' => 'nullable|string',
            'authority_remarks' => 'nullable|string',
        ]);
        $personnel->next_of_kin()->create($request->only([
            'full_name',
            'relation',
            'date_of_birth',
            'nationality',
            'place_of_birth',
            'email',
            'phone',
            'mobile',
            'address',
            'authority_remarks',
        ]));

        return redirect()->route('admin.personnel.next_of_kin', $this->modalRouteParams($request, $personnel->uuid))->with([
            'message' => 'Next of Kin added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storePost(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
        $request->validate([
            'post_from' => 'nullable|integer',
            'post_to' => 'nullable|integer',
            'post_type' => 'nullable|string',
            'wef_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'appointment_id' => 'nullable|integer',
            'appointment_type' => 'nullable|string',
            'authority_remarks' => 'nullable|string',
        ]);
        $personnel->posts()->create($request->only([
            'post_from',
            'post_to',
            'post_type',
            'wef_date',
            'end_date',
            'appointment_id',
            'appointment_type',
            'authority_remarks',
        ]));

        return redirect()->route('admin.personnel.posts', $this->modalRouteParams($request, $personnel->uuid))->with([
            'message' => 'Post added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storeRemark(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
        $request->validate([
            'remark' => 'required|string',
        ]);
        $personnel->remarks()->create($request->only(['remark']));

        return redirect()->route('admin.personnel.remarks', $this->modalRouteParams($request, $personnel->uuid))->with([
            'message' => 'Remark added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storeInterview(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
        $request->validate([
            'interview_date' => 'required|date',
            'reason' => 'nullable|string',
            'authority_remarks' => 'nullable|string',
        ]);
        $personnel->interviews()->create($request->only([
            'interview_date',
            'reason',
            'authority_remarks',
        ]));

        return redirect()->route('admin.personnel.interviews', $this->modalRouteParams($request, $personnel->uuid))->with([
            'message' => 'Interview added successfully',
            'alert-type' => 'success',
        ]);
    }

    public function courses(Request $request, $uuid)
    {
        return $this->relatedView($uuid, 'courses', 'Courses', $request->boolean('modal'));
    }

    public function promotions(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)
            ->with(['promotions.promoted_rank', 'promotions.previous_rank'])
            ->firstOrFail();

        return view('admin.personnel_related_list', [
            'title' => 'Promotions',
            'personnel' => $personnel,
            'items' => $personnel->promotions,
            'units' => Unit::all(),
            'ranks' => rank::all(),
            'appointments' => Appointment::all(),
            'isModal' => $request->boolean('modal'),
        ]);
    }

    public function documents(Request $request, $uuid)
    {
        return $this->relatedView($uuid, 'documents', 'Documents', $request->boolean('modal'));
    }

    public function family(Request $request, $uuid)
    {
        return $this->relatedView($uuid, 'family', 'Family', $request->boolean('modal'));
    }

    public function nextOfKin(Request $request, $uuid)
    {
        return $this->relatedView($uuid, 'next_of_kin', 'Next of Kin', $request->boolean('modal'));
    }

    public function posts(Request $request, $uuid)
    {
        $personnel = Personnel::where('uuid', $uuid)
            ->with(['posts.posted_from', 'posts.posted_to'])
            ->firstOrFail();

        return view('admin.personnel_related_list', [
            'title' => 'Posts',
            'personnel' => $personnel,
            'items' => $personnel->posts,
            'units' => Unit::all(),
            'ranks' => rank::all(),
            'appointments' => Appointment::all(),
            'isModal' => $request->boolean('modal'),
        ]);
    }

    public function remarks(Request $request, $uuid)
    {
        return $this->relatedView($uuid, 'remarks', 'Remarks', $request->boolean('modal'));
    }

    public function interviews(Request $request, $uuid)
    {
        return $this->relatedView($uuid, 'interviews', 'Interviews', $request->boolean('modal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'personnel_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'svcnumber' => ['required', 'unique:personnels,svcnumber'],
            'surname' => 'required',
            'othernames' => 'required',
            'mobile_no' => 'required|digits:10',
        ]);
        $save_url = null;
        if ($request->hasFile('personnel_image')) {
            $image = $request->file('personnel_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('upload/personnel/' . $name_gen);
            $save_url = 'upload/personnel/' . $name_gen;
        }
        $firstLetterFirstName = substr($request->first_name, 0, 1);
        $firstLettersOthernames = '';
        if (!empty($request->othernames)) {
            $othernames = explode(' ', $request->othernames);

            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }
        $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);
        Personnel::create([
            'unit_name' => $request->unit_name,
            'rank_id' => $request->rank_id,
            'arm_of_service' => $request->arm_of_service,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'first_name' => $request->first_name,
            'othernames' => $request->othernames,
            'initial' => $initials,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'height' => $request->height,
            'blood_group' => $request->blood_group,
            'virtual_mark' => $request->virtual_mark,
            'service_category' => $request->service_category,
            'personnel_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
        ]);
        $notification = [
            'message' => 'Personnel Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('personal-view')->with($notification);
    }

    public function edit($uuid)
    {
        $personel = Personnel::where('uuid', $uuid)->first();
        if (!$personel) {
            abort(404);
        }
        $unit = Unit::all();
        $ranks = rank::all();
        $service = Service::all();
        return view('deployment.personnel.edit', compact('personel', 'unit', 'ranks', 'service'));
    }

    public function update(Request $request)
    {
        $uuid = $request->uuid;
        // Calculate initials
        $firstLetterFirstName = substr($request->first_name, 0, 1);
        $firstLettersOthernames = '';
        if (!empty($request->othernames)) {
            $othernames = explode(' ', $request->othernames);

            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }
        $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);
        // Prepare update data
        $updateData = [
            'unit_id' => $request->unit_id,
            'rank_id' => $request->rank_id,
            'arm_of_service' => $request->arm_of_service,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'first_name' => $request->first_name,
            'othernames' => $request->othernames,
            'initial' => $initials,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'height' => $request->height,
            'virtual_mark' => $request->virtual_mark,
            'blood_group' => $request->blood_group,
            'service_category' => $request->service_category,
            'updated_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];
        // Check if a new image is uploaded
        if ($request->hasFile('personnel_image')) {
            $image = $request->file('personnel_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('upload/personnel/' . $name_gen);
            $save_url = 'upload/personnel/' . $name_gen;
            $updateData['personnel_image'] = $save_url;
        }
        $updateDat = Personnel::where('uuid', $uuid)->firstOrFail();
        // Retain existing image if no new image is uploaded
        if (!$request->hasFile('personnel_image')) {
            unset($updateData['personnel_image']);
        }
        $updateDat->update($updateData);
        $notification = [
            'message' => $request->hasFile('personnel_image')
            ? 'Personnel Updated with Image Successfully'
            : 'Personnel Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('personal-view')->with($notification);
    }

//     public function update(Request $request)
// {
//     $uuid = $request->uuid;

//     // Calculate initials
//     $firstLetterFirstName = substr($request->first_name, 0, 1);
//     $firstLettersOthernames = '';
//     if (!empty($request->othernames)) {
//         $othernames = explode(' ', $request->othernames);
//         foreach ($othernames as $othername) {
//             $firstLettersOthernames .= substr($othername, 0, 1);
//         }
//     }
//     $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);

//     // Prepare update data for Personnel
//     $updateData = [
//         'unit_id' => $request->unit_id,
//         'rank_id' => $request->rank_id,
//         'arm_of_service' => $request->arm_of_service,
//         'svcnumber' => $request->svcnumber,
//         'surname' => $request->surname,
//         'first_name' => $request->first_name,
//         'othernames' => $request->othernames,
//         'initial' => $initials,
//         'mobile_no' => $request->mobile_no,
//         'email' => $request->email,
//         'gender' => $request->gender,
//         'height' => $request->height,
//         'virtual_mark' => $request->virtual_mark,
//         'service_category' => $request->service_category,
//         'updated_by' => Auth::user()->id,
//         'created_at' => Carbon::now(),
//     ];

//     // Check if a new image is uploaded
//     if ($request->hasFile('personnel_image')) {
//         $image = $request->file('personnel_image');
//         $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
//         Image::make($image)->resize(200, 200)->save('upload/personnel/' . $name_gen);
//         $save_url = 'upload/personnel/' . $name_gen;
//         $updateData['personnel_image'] = $save_url;
//     }

//     // Update the Personnel record
//     $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
//     $personnel->update($updateData);

//     // If the image is updated, update associated records in GafMissionRecord
//     if ($request->hasFile('personnel_image')) {
//         GafMissionRecord::where('svcnumber', $request->svcnumber)
//             ->update(['personnel_image' => $save_url]);
//     }

//     $notification = [
//         'message' => $request->hasFile('personnel_image')
//             ? 'Personnel Updated with Image Successfully'
//             : 'Personnel Updated Successfully',
//         'alert-type' => 'success',
//     ];
//     return redirect()->route('personal-view')->with($notification);
// }

    public function delete($uuid)
    {
        $personel = Personnel::where('uuid', $uuid)->first();
        if (!$personel) {
            abort(404);
        }
        $personel->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ]);
        Excel::import(new PersonnelImport, $request->file('file'));
        $notification = [
            'message' => 'Imported Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    public function downloadSampleExcel()
    {
        // $filePath = storage_path('app/public/sample_excel/personnel.csv');
        // return response()->download($filePath, 'personnel.csv');
        // $file_path = public_path('sample_excel/personnel.csv');
        // $file_name = 'personnel.csv';
        // return response()->download($file_path, $file_name);

        $path = Storage::path('personnel.csv');

        return response()->file($path);
    }
}
