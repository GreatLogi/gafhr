<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Imports\GafMissionDeploymentImport;
use App\Imports\GafMissionReturnedImport;
use App\Imports\GAFTOTRAVELRECORDImport;
use App\Models\Country;
use App\Models\GAFTOTRAVELRECORD;
use App\Models\Mission;
use App\Models\Personnel;
use App\Models\rank;
use App\Models\Service;
use App\Models\unit;
use App\Rules\DepartureDateRule;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class TrackTravelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        return view('deployment.records.index');
    }

    public function Details($uuid)
    {
        $data = GAFTOTRAVELRECORD::where('uuid', $uuid)->first();
        if (!$data) {
            abort(404);
        }
        return View('deployment.pdf.personnel_pdf', compact('data'));
    }

    public function create()
    {
        $countries = array_map('strtoupper', [
            'Afghanistan',
            'Albania',
            'Algeria',
            'Andorra',
            'Angola',
            'Antigua and Barbuda',
            'Argentina',
            'Armenia',
            'Australia',
            'Austria',
            'Azerbaijan',
            'Bahamas',
            'Bahrain',
            'Bangladesh',
            'Barbados',
            'Belarus',
            'Belgium',
            'Belize',
            'Benin',
            'Bhutan',
            'Bolivia',
            'Bosnia and Herzegovina',
            'Botswana',
            'Brazil',
            'Brunei',
            'Bulgaria',
            'Burkina Faso',
            'Burundi',
            'Cabo Verde',
            'Cambodia',
            'Cameroon',
            'Canada',
            'Central African Republic',
            'Chad',
            'Chile',
            'China',
            'Colombia',
            'Comoros',
            'Congo',
            'Costa Rica',
            'Croatia',
            'Cuba',
            'Cyprus',
            'Czechia',
            "Côte d'Ivoire",
            'Denmark',
            'Djibouti',
            'Dominica',
            'Dominican Republic',
            'Ecuador',
            'Egypt',
            'El Salvador',
            'Equatorial Guinea',
            'Eritrea',
            'Estonia',
            'Eswatini',
            'Ethiopia',
            'Fiji',
            'Finland',
            'France',
            'Gabon',
            'Gambia',
            'Georgia',
            'Germany',
            'Ghana',
            'Greece',
            'Grenada',
            'Guatemala',
            'Guinea',
            'Guinea-Bissau',
            'Guyana',
            'Haiti',
            'Honduras',
            'Hungary',
            'Iceland',
            'India',
            'Indonesia',
            'Iran',
            'Iraq',
            'Ireland',
            'Israel',
            'Italy',
            'Jamaica',
            'Japan',
            'Jordan',
            'Kazakhstan',
            'Kenya',
            'Kiribati',
            'Kuwait',
            'Kyrgyzstan',
            'Laos',
            'Latvia',
            'Lebanon',
            'Lesotho',
            'Liberia',
            'Libya',
            'Liechtenstein',
            'Lithuania',
            'Luxembourg',
            'Madagascar',
            'Malawi',
            'Malaysia',
            'Maldives',
            'Mali',
            'Malta',
            'Marshall Islands',
            'Mauritania',
            'Mauritius',
            'Mexico',
            'Micronesia',
            'Moldova',
            'Monaco',
            'Mongolia',
            'Montenegro',
            'Morocco',
            'Mozambique',
            'Myanmar',
            'Namibia',
            'Nauru',
            'Nepal',
            'Netherlands',
            'New Zealand',
            'Nicaragua',
            'Niger',
            'Nigeria',
            'North Korea',
            'North Macedonia',
            'Norway',
            'Oman',
            'Pakistan',
            'Palau',
            'Palestine',
            'Panama',
            'Papua New Guinea',
            'Paraguay',
            'Peru',
            'Philippines',
            'Poland',
            'Portugal',
            'Qatar',
            'Romania',
            'Russia',
            'Rwanda',
            'Saint Kitts and Nevis',
            'Saint Lucia',
            'Saint Vincent and the Grenadines',
            'Samoa',
            'San Marino',
            'Sao Tome and Principe',
            'Saudi Arabia',
            'Senegal',
            'Serbia',
            'Seychelles',
            'Sierra Leone',
            'Singapore',
            'Slovakia',
            'Slovenia',
            'Solomon Islands',
            'Somalia',
            'South Africa',
            'South Korea',
            'South Sudan',
            'Spain',
            'Sri Lanka',
            'Sudan',
            'Suriname',
            'Sweden',
            'Switzerland',
            'Syria',
            'Taiwan',
            'Tajikistan',
            'Tanzania',
            'Thailand',
            'Timor-Leste',
            'Togo',
            'Tonga',
            'Trinidad and Tobago',
            'Tunisia',
            'Turkey',
            'Turkmenistan',
            'Tuvalu',
            'Uganda',
            'Ukraine',
            'United Arab Emirates',
            'United Kingdom',
            'United States',
            'Uruguay',
            'Uzbekistan',
            'Vanuatu',
            'Vatican City',
            'Venezuela',
            'Vietnam',
            'Yemen',
            'Zambia',
            'Zimbabwe',
        ]);

        return view('deployment.records.create', compact('countries'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            'return_date' => 'required|date',
            'departure_date' => ['required', 'date', new DepartureDateRule($request->return_date)],
            'country' => 'required',
            'passport_expiry_date' => 'required',
            'today_date' => 'required',
            'passport_number' => 'required',
            'mobile_no' => 'required|regex:/^0[0-9]{9}$/',
        ]);
        $existingRecord = GAFTOTRAVELRECORD::where('svcnumber', $request->svcnumber)
            ->whereIn('status', ['0', '1', '2'])
            ->first();
        if ($existingRecord) {
            if ($existingRecord->status == '0') {
                $notification = [
                    'message' => 'The person on already Standby.',
                    'alert-type' => 'error',
                ];
                return redirect()->back()->withInput()->with($notification);
            } elseif ($existingRecord->status == '1') {
                $notification = [
                    'message' => 'The person is on pending deployment.',
                    'alert-type' => 'info',
                ];
                return redirect()->back()->withInput()->with($notification);
            } elseif ($existingRecord->status == '2') {
                $notification = [
                    'message' => 'Personel already on a mission.',
                    'alert-type' => 'warning',
                ];
                return redirect()->route('view-record')->with($notification);
            }
        }
        $existingPassportRecord = GAFTOTRAVELRECORD::where('passport_number', $request->passport_number)->first();
        if ($existingPassportRecord) {
            if ($existingPassportRecord->svcnumber != $request->svcnumber) {
                $notification = [
                    'message' => 'This passport number is already associated with another person.',
                    'alert-type' => 'error',
                ];
                return redirect()->back()->withInput()->with($notification);
            }
        }
        $today_date = new DateTime($request->today_date);
        $departure_date = new DateTime($request->departure_date);
        $departuredays = $today_date->diff($departure_date);
        $departure = $departuredays->days;
        $departure_date = new DateTime($request->departure_date);
        $return_date = new DateTime($request->return_date);
        $arrivaldays = $departure_date->diff($return_date);
        $arrival = $arrivaldays->days;
        $return_date = new DateTime($request->return_date);
        $passport_expiry_date = new DateTime($request->passport_expiry_date);
        if ($passport_expiry_date < $return_date) {
            $notification = [
                'message' => 'Passport will expire before the person returns.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->withInput()->with($notification);
        }
        $passport_expiry_days = $return_date->diff($passport_expiry_date);
        $passport = $passport_expiry_days->days;
        $firstLetterFirstName = substr($request->first_name, 0, 1);
        $firstLettersOthernames = '';

        if (!empty($request->othernames)) {
            $othernames = explode(' ', $request->othernames);
            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }
        // Build initials
        if (strtoupper($request->service_category) === 'OFFICER') {
            // Officer → Initials + Surname
            $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);
        } else {
            // Others → Surname + Initials
            $initials = strtoupper($request->surname) . ' ' . strtoupper($firstLetterFirstName . $firstLettersOthernames);
        }
        $data = new GAFTOTRAVELRECORD();
        $data->svcnumber = $request->svcnumber;
        $data->personnel_image = $request->personnel_image;
        $data->initial = $request->initial;
        $data->surname = $request->surname;
        $data->othernames = $request->othernames;
        $data->first_name = $request->first_name;
        $data->gender = $request->gender;
        $data->mobile_no = $request->mobile_no;
        $data->unit_name = $request->unit_name;
        $data->rank_name = $request->rank_name;
        $data->email = $request->email;
        $data->blood_group = $request->blood_group;
        $data->arm_of_service = $request->arm_of_service;
        $data->personnel_image = $request->personnel_image;
        $data->today_date = date('Y-m-d', strtotime($request->today_date));
        $data->departure_date = $request->departure_date;
        $data->departuredays = $departure;
        $data->country = $request->country;
        $data->return_date = $request->return_date;
        $data->arrivaldays = $arrival;
        $data->destination_address = $request->destination_address;
        $data->ticket_number = $request->ticket_number;
        $data->departure_flight_number = $request->departure_flight_number;
        $data->return_flight_number = $request->return_flight_number;
        $data->etd = $request->etd;
        $data->eta = $request->eta;
        $data->amount = $request->amount;
        $data->purpose = $request->purpose;
        $data->sponsorship = $request->sponsorship;
        $data->responsibility = $request->responsibility;
        $data->passport_number = $request->passport_number;
        $data->service_category = $request->service_category;
        $data->passport_expiry_date = $request->passport_expiry_date;
        $data->remarks = $request->remarks;
        $data->status = $request->status;
        $data->initial = $initials;
        $data->travelled_with_civ = $request->travelled_with_civ;
        $data->civ_state = $request->civ_state;
        $data->civ_full_name = $request->civ_full_name;
        $data->civ_gender = $request->civ_gender;
        $data->civ_mobile_no = $request->civ_mobile_no;
        $data->civ_email = $request->civ_email;
        $data->updated_by = Auth::user()->id;
        $data->created_by = Auth::user()->id;
        $data->save();
        $notification = [
            'message' => 'Record Inserted  Successfully',
            'alert-type' => 'success',
        ];
        $showModal = true;
        return redirect()->route('record-manager', compact('data'))->with($notification);
    }

    public function Edit($uuid)
    {
        $ranks = rank::all();
        $serv = Service::all();
        $units = unit::all();
        $record = GAFTOTRAVELRECORD::where('uuid', $uuid)->first();
        if (!$record) {
            abort(404);
        }
        return view('deployment.records.edit', compact('record', 'ranks', 'serv', 'units'));
    }

    public function Edit_Civilian($uuid)
    {
        $record = GAFTOTRAVELRECORD::where('uuid', $uuid)->first();
        if (!$record) {
            abort(404);
        }
        return view('deployment.records.edit_civilian', compact('record'));
    }
    public function Edit_Repatriation($uuid)
    {
        $data = GAFTOTRAVELRECORD::where('uuid', $uuid)->first();
        if (!$data) {
            abort(404);
        }
        return view('deployment.records.repatriation', compact('data'));
    }

    public function Update(Request $request, $uuid)
    {
        $data = GAFTOTRAVELRECORD::where('uuid', $uuid)->first();
        if (!$data) {
            abort(404);
        }

        $existingPassportRecord = GAFTOTRAVELRECORD::where('passport_number', $request->passport_number)->where('uuid', '!=', $uuid)->first();
        if ($existingPassportRecord) {
            $notification = [
                'message' => 'This passport number is already associated with another person.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->withInput()->with($notification);
        }

        $departure_date = new DateTime($request->departure_date);
        $return_date = new DateTime($request->return_date);
        $arrivaldays = $departure_date->diff($return_date)->days;
        // Update record attributes
        $data->surname = $request->surname;
        $data->othernames = $request->othernames;
        $data->first_name = $request->first_name;
        $data->gender = $request->gender;
        $data->mobile_no = $request->mobile_no;
        $data->rank_name = $request->rank_name;
        $data->email = $request->email;
        $data->departure_date = $departure_date->format('Y-m-d');
        $data->departuredays = $arrivaldays;
        $data->country = $request->country;
        $data->return_date = $return_date->format('Y-m-d');
        $data->arrivaldays = $arrivaldays;
        $data->destination_address = $request->destination_address;
        $data->ticket_number = $request->ticket_number;
        $data->departure_flight_number = $request->departure_flight_number;
        $data->return_flight_number = $request->return_flight_number;
        $data->etd = $request->etd;
        $data->eta = $request->eta;
        $data->amount = $request->amount;
        $data->status = $request->status;
        $data->purpose = $request->purpose;
        $data->sponsorship = $request->sponsorship;
        $data->responsibility = $request->responsibility;
        $data->passport_number = $request->passport_number;
        $data->service_category = $request->service_category;
        $data->passport_expiry_date = $request->passport_expiry_date;
        $data->remarks = $request->remarks;
        $data->travelled_with_civ = $request->travelled_with_civ;
        $data->civ_state = $request->civ_state;
        $data->civ_full_name = $request->civ_full_name;
        $data->civ_gender = $request->civ_gender;
        $data->civ_mobile_no = $request->civ_mobile_no;
        $data->updated_by = Auth::user()->id;
        $data->save();
        $notification = [
            'message' => 'Record Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('record-manager')->with($notification);
    }

    public function Repatriation_Update(Request $request, $uuid)
    {
        $data = GAFTOTRAVELRECORD::where('uuid', $uuid)->first();
        if (!$data) {
            abort(404);
        }
        $data->remarks = $request->remarks;
        $data->status = 6;
        $data->return_date = today();
        $data->save();
        $notification = [
            'message' => 'Repatriated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('record-manager')->with($notification);
    }

    public function Delete($uuid)
    {
        $data = GAFTOTRAVELRECORD::where('uuid', $uuid)->first();
        if (!$data) {
            abort(404);
        }
        $data->delete();
        $notification = [
            'message' => 'Record Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }

    public function Pending()
    {
        $personnel_reschedule = GAFTOTRAVELRECORD::orderBy('departure_date', 'desc')->orderBy('id', 'desc')->where('status', '3')->get();
        $data = GAFTOTRAVELRECORD::orderBy('departure_date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();
       foreach ($data as $record) {
            if ($record->status == '5' || $record->status == '3') {
                $record->arrivaldays = 0;
                $number_of_days_since_account_creation = (new DateTime($record->today_date))->diff(new DateTime)->days;
                $number_of_days_left = (int) $record->departuredays - $number_of_days_since_account_creation;
                $record->departuredays = $number_of_days_left;
            } elseif ($record->status == '1') {
                $record->departuredays = 0;
                $number_of_days_left_for_arrival = (new DateTime($record->departure_date))->diff(new DateTime)->days;
                $number_of_days_left_for_return = (int) $record->arrivaldays - $number_of_days_left_for_arrival;
                $record->arrivaldays = $number_of_days_left_for_return;
            } elseif ($record->status == '4') {
                $record->arrivaldays = 0;
                $record->departuredays = 0;
            }
        }
        foreach ($personnel_reschedule as $record) {
            if ($record->status == '5' || $record->status == '3') {
                $record->arrivaldays = 0;
                $number_of_days_since_account_creation = (new DateTime($record->today_date))->diff(new DateTime)->days;
                $number_of_days_left = (int) $record->departuredays - $number_of_days_since_account_creation;
                $record->departuredays = $number_of_days_left;
            } elseif ($record->status == '1') {
                $record->departuredays = 0;
                $number_of_days_left_for_arrival = (new DateTime($record->departure_date))->diff(new DateTime)->days;
                $number_of_days_left_for_return = (int) $record->arrivaldays - $number_of_days_left_for_arrival;
                $record->arrivaldays = $number_of_days_left_for_return;
            } elseif ($record->status == '4') {
                $record->arrivaldays = 0;
                $record->departuredays = 0;
            }
        }
        $data = $data->sortBy('departuredays');
        return View('deployment.records.pending', compact('data', 'personnel_reschedule'));
    }


    
    public function Approve($id)
    {
        $data = GAFTOTRAVELRECORD::findOrFail($id);
        if ($data) {
            $data->status = 1;
            $data->save();
            $notification = [
                'message' => 'Status Approved Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('record-manager')->with($notification);
        }
    }

    public function Bulk_Approve(Request $request)
    {
        $recordIds = $request->input('record_ids');
        $updatedRecords = GAFTOTRAVELRECORD::whereIn('id', $recordIds)->update(['status' => 1]);
        if ($updatedRecords > 0) {
            $notification = [
                'message' => 'Status Pending Approved Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('record-manager')->with($notification);
        } else {
            $notification = [
                'message' => 'No records were updated',
                'alert-type' => 'warning',
            ];
            return redirect()->back()->with($notification);
        }
    }

    public function Bulk_Deployed(Request $request)
    {
        $recordIds = $request->input('record_ids');
        $todayDate = now()->toDateString();
        $updatedRecords = GAFTOTRAVELRECORD::whereIn('id', $recordIds)->update([
            'status' => 2,
            'departure_date' => $todayDate,
        ]);
        if ($updatedRecords > 0) {
            $notification = [
                'message' => 'Deployed Approved Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('record-manager')->with($notification);
        } else {
            $notification = [
                'message' => 'No records were updated',
                'alert-type' => 'warning',
            ];
            return redirect()->back()->with($notification);
        }
    }
    public function Bulk_Return(Request $request)
    {
        $recordIds = $request->input('record_ids');
        $todayDate = Carbon::today();
        $updatedRecords = GAFTOTRAVELRECORD::whereIn('id', $recordIds)->update([
            'status' => 5,
            'return_date' => $todayDate,
        ]);
        if ($updatedRecords > 0) {
            $notification = [
                'message' => 'Bulk Returned Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('record-manager')->with($notification);
        } else {
            $notification = [
                'message' => 'No records were updated',
                'alert-type' => 'warning',
            ];
            return redirect()->back()->with($notification);
        }
    }

    public function bulkDelete(Request $request)
    {
        $recordIds = $request->input('record_ids');
        $deletedRecordsCount = GAFTOTRAVELRECORD::whereIn('id', $recordIds)->delete();
        if ($deletedRecordsCount > 0) {
            $response = [
                'message' => 'Bulk Delete Successful',
                'status' => 'success',
            ];
        } else {
            $response = [
                'message' => 'No records were deleted',
                'status' => 'warning',
            ];
        }
        return response()->json($response);
    }

    public function OnMission()
    {
        $data = GAFTOTRAVELRECORD::where('status', '2')->get();
        foreach ($data as $record) {
            if ($record->status == '2') {
                $departureDate = new DateTime($record->departure_date);
                $currentDate = new DateTime();
                if ($departureDate->format('Y-m-d') == $currentDate->format('Y-m-d')) {
                    $record->departuredays = 0;
                    $number_of_days_left_for_arrival = $departureDate->diff($currentDate)->days;
                    $number_of_days_left_for_return = (int) $record->arrivaldays - $number_of_days_left_for_arrival;
                    $record->arrivaldays = $number_of_days_left_for_return;
                } else {
                    // Set departuredays and arrivaldays to zero
                    $record->departuredays = 0;
                    $record->arrivaldays = 0;
                }
            } elseif ($record->status == '5') {
                $record->arrivaldays = 0;
                $record->departuredays = 0;
            }
        }
        $data = $data->sortBy('arrivaldays');
        return view('deployment.records.deployment', compact('data'));
    }

    public function Approve_Deployment()
    {
        $data = GAFTOTRAVELRECORD::where('status', '1')->get();
        foreach ($data as $record) {
            if ($record->status == '1') {
                $departureDate = new DateTime($record->departure_date);
                $currentDate = new DateTime();
                if ($departureDate->format('Y-m-d') == $currentDate->format('Y-m-d')) {
                    $record->departuredays = 0;
                    $number_of_days_left_for_arrival = $departureDate->diff($currentDate)->days;
                    $number_of_days_left_for_return = (int) $record->arrivaldays - $number_of_days_left_for_arrival;
                    $record->arrivaldays = $number_of_days_left_for_return;
                } else {
                    $record->departuredays = 0;
                    $record->arrivaldays = 0;
                }
            } elseif ($record->status == '5') {
                $record->arrivaldays = 0;
                $record->departuredays = 0;
            }
        }
        $data = $data->sortBy('arrivaldays');
        return view('deployment.records.approve', compact('data'));
    }

    public function Cancel()
    {
        $data = GAFTOTRAVELRECORD::orderBy('departure_date', 'desc')->orderBy('id', 'desc')->where('status', '2')->get();
        return view('deployment.records.cancelled', compact('data'));
    }

    public function oncancel($id)
    {
        $data = GAFTOTRAVELRECORD::findOrFail($id);
        if ($data) {
            $data->status = 2;
            $data->save();
            $notification = [
                'message' => 'Status Cancel Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('record-manager')->with($notification);
        }
    }

    public function OnSchedule()
    {
        $data = GAFTOTRAVELRECORD::orderBy('departure_date', 'desc')->orderBy('id', 'desc')->where('status', '3')->get();

        return view('deployment.records.rescheduled', compact('data'));
    }

    public function Rescheduled($id)
    {
        $data = GAFTOTRAVELRECORD::findOrFail($id);
        if ($data) {
            $data->status = 4;
            $data->save();
            $notification = [
                'message' => 'Status Rescheduled Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('record-manager')->with($notification);
        }
    }

    public function Returned()
    {
        return view('deployment.records.returned');
    }

    public function Arrived($id)
    {
        $data = GAFTOTRAVELRECORD::findOrFail($id);
        if ($data) {
            $data->status = 5;
            $data->save();
            $notification = [
                'message' => 'Status Return Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('record-manager')->with($notification);
        }
    }

    public function Pendingdeparturenotify()
    {
        $data = GAFTOTRAVELRECORD::where('status', '0')->get();
        $number_of_personel_ready_to_depart = 0;
        $number_of_personel_ready_to_depart = 0;
        foreach ($data as $record) {
            if ($record->status == '0' || $record->status == '3') {
                $record->arrivaldays = 0;
                $number_of_days_since_account_creation = (new DateTime($record->today_date))->diff(new DateTime)->days;
                $number_of_days_left = (int) $record->departuredays - $number_of_days_since_account_creation;
                $record->departuredays = $number_of_days_left;
            } elseif ($record->status == '2') {
                $record->departuredays = 0;
                $number_of_days_left_for_arrival = (new DateTime($record->departure_date))->diff(new DateTime)->days;
                $number_of_days_left_for_return = (int) $record->arrivaldays - $number_of_days_left_for_arrival;
                $record->arrivaldays = $number_of_days_left_for_return;
            } elseif ($record->status == '5') {
                $record->arrivaldays = 0;
                $record->departuredays = 0;
            }
        }
        $data = $data->sortBy('departuredays');
        return View('deployment.records.notificationpage', compact('data'));
    }

    public function ImportDeployment(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ]);
        $import = new GafMissionDeploymentImport();
        Excel::import($import, $request->file('file'));
        $importedRows = $import->getImportedRows();
        $notification = [
            'message' => '',
            'alert-type' => 'success',
        ];
        $importStatus = 'success'; // Default status is success
        foreach ($importedRows as $row) {
            if ($row['status'] === 'warning') {
                $importStatus = 'warning';
                $notification['message'] .= $row['message'] . '<br>';
            }
        }
        $notification['alert-type'] = $importStatus;
        if ($importStatus === 'success') {
            $notification['message'] = 'Imported Successfully';
        }
        return redirect()->back()->with($notification);
    }

    public function import_return(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ]);
        $import = new GafMissionReturnedImport();
        Excel::import($import, $request->file('file'));
        $importedRows = $import->getImportedRows();
        $notification = [
            'message' => '',
            'alert-type' => 'success',
        ];
        $importStatus = 'success';
        foreach ($importedRows as $row) {
            if ($row['status'] === 'warning') {
                $importStatus = 'warning';
                $notification['message'] .= $row['message'] . '<br>';
            }
        }
        $notification['alert-type'] = $importStatus;
        if ($importStatus === 'success') {
            $notification['message'] = 'Imported Successfully';
        }

        return redirect()->back()->with($notification);
    }



    public function fetchDetails(Request $request)
    {
        $svcNumber = $request->input('svcNumber');
        $personnel = Personnel::with(['rank', 'service', 'unit'])
            ->where('svcnumber', $svcNumber)
            ->first();
        if ($personnel) {
            $rankName = $personnel->rank ? $personnel->rank->rank_name : null;
            $unitName = $personnel->unit ? $personnel->unit->unit_name : null;
            return response()->json([
                'svcnumber' => $personnel->svcnumber,
                'rank_name' => $rankName,
                'surname' => $personnel->surname,
                'first_name' => $personnel->first_name,
                'othernames' => $personnel->othernames,
                'gender' => $personnel->gender,
                'mobile_no' => $personnel->mobile_no,
                'blood_group' => $personnel->blood_group,
                'unit_id' => $unitName,
                'email' => $personnel->email,
                'personnel_image' => $personnel->personnel_image,
                'service_category' => $personnel->service_category,
                'arm_of_service' => $personnel->service->arm_of_service,
                'not_found' => false,
            ]);
        } else {
            return response()->json([
                'not_found' => true,
            ]);
        }
    }
}
