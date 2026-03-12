<?php

namespace App\Imports;

use App\Models\GafMissionRecord;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Auth;

class GafMissionDeploymentImport implements ToModel, WithChunkReading, WithHeadingRow
{

    public function __construct()
    {
        // Ensure that user is authenticated before proceeding with import
        if (!Auth::check()) {
            throw new \Exception("User must be authenticated to perform the import.");
        }
    }
    protected $importedRows = [];
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $existingDeployment = GafMissionRecord::where('svcnumber', $row['svcnumber'])
            ->whereIn('status', [0, 1, 2])
            ->exists();

        if ($existingDeployment) {
            $existingStatus = GafMissionRecord::where('svcnumber', $row['svcnumber'])
                ->whereIn('status', [0, 1, 2])
                ->value('status');
            $statusNames = [
                0 => 'STANDBY',
                1 => 'APPROVED',
                2 => 'DEPLOYED'
            ];
            $statusName = $statusNames[$existingStatus];
            $this->importedRows[] = [
                'status' => 'warning',
                'message' => 'Service Number: ' . $row['svcnumber'] . ' already ' . $statusName . ', skipping import'
            ];
            return null;
        }
        $firstLetterFirstName = substr($row['first_name'], 0, 1);
        $firstLettersOthernames = '';

        if (!empty($row['othernames'])) {
            $othernames = explode(' ', $row['othernames']);

            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }
        $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($row['surname']);
        if (
            empty($row['svcnumber']) || empty($row['surname']) || empty($row['appointment_name']) ||
            empty($row['othernames']) || empty($row['gender']) || empty($row['unit_name']) || empty($row['rank_name']) ||
            empty($row['first_name']) || empty($row['initial']) || empty($row['mobile_no']) ||
            empty($row['email']) || empty($row['arm_of_service']) || empty($row['today_date']) ||
            empty($row['departure_date']) || empty($row['departuredays']) || empty($row['country']) ||
            empty($row['arrivaldays']) || empty($row['status']) || empty($row['today_date']) ||
            empty($row['chalk_list']) || empty($row['ghanbatt_name']) || empty($row['service_category']) ||
            empty($row['return_date']) || empty($row['mission_name']) || empty($row['un_id']) ||
            empty($row['coy']) || empty($row['cell']) || empty($row['passport_number']) ||
            empty($row['expiration_date']) || empty($row['remarks']) || empty($row['today_date'])
        ) {
            $todayDate = empty($row['today_date']) ? today() : Date::excelToDateTimeObject($row['today_date'])->format('Y-m-d');
            $departureDate = empty($row['departure_date']) ? null : Date::excelToDateTimeObject($row['departure_date'])->format('Y-m-d');
            $arrivalDate = empty($row['return_date']) ? null : Date::excelToDateTimeObject($row['return_date'])->format('Y-m-d');
            if ($departureDate && $arrivalDate) {
                $departuredays = Carbon::parse($departureDate)->diff(Carbon::parse($todayDate))->days;
                $arrivaldays = Carbon::parse($arrivalDate)->diff(Carbon::parse($departureDate))->days;
            } else {
                $departuredays = null;
                $arrivaldays = null;
            }
            // Check if gender is already 'MALE' or 'FEMALE', otherwise check if it's 'M' or 'F'
            if ($row['gender'] == 'MALE' || $row['gender'] == 'FEMALE') {
                $mappedGender = $row['gender'];
            } elseif ($row['gender'] == 'M') {
                $mappedGender = 'MALE';
            } elseif ($row['gender'] == 'F') {
                $mappedGender = 'FEMALE';
            } else {
                $mappedGender = $row['gender'];
            }
            if (strlen($row['mobile_no']) === 9 && is_numeric($row['mobile_no'])) {
                $row['mobile_no'] = '0' . $row['mobile_no'];
            } 
            // else {
            //     return null;
            // }
            return new GafMissionRecord([
                'svcnumber' => $row['svcnumber'],
                'rank_name' => $row['rank_name'],
                'surname' => $row['surname'],
                'othernames' => $row['othernames'],
                'first_name' => $row['first_name'],
                'initial' => $initials,
                'gender' => $mappedGender,
                'mobile_no' => $row['mobile_no'],
                'email' => $row['email'],
                'arm_of_service' => $row['arm_of_service'],
                'unit_name' => $row['unit_name'],
                'departure_date' => $departureDate,
                'departuredays' => $departuredays,
                'country' => $row['country'],
                'arrivaldays' => $arrivaldays,
                'status' => 2,
                'today_date' => $todayDate,
                'chalk_list' => $row['chalk_list'],
                'appointment_name' => $row['appointment_name'],
                'ghanbatt_name' => $row['ghanbatt_name'],
                'service_category' => $row['service_category'],
                'return_date' => $arrivalDate,
                'mission_name' => $row['mission_name'],
                'passport_number' => $row['passport_number'],
                'created_at' => now(),
                'created_by' => Auth::user() ? Auth::user()->id : null,
                'updated_by' => Auth::user() ? Auth::user()->id : null,
            ]);
        }
    }
    public function chunkSize(): int
    {
        return 1000;
    }
    public function getImportedRows()
    {
        return $this->importedRows;
    }
}
