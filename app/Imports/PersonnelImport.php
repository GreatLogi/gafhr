<?php

namespace App\Imports;

use App\Models\Personnel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PersonnelImport implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        // Check if all required fields are present
        if (
            empty($row['svcnumber']) || empty($row['surname']) || empty($row['first_name']) ||
            empty($row['othernames']) || empty($row['gender']) || empty($row['blood_group']) ||
            empty($row['arm_of_service']) || is_null($row['mobile_no']) ||
            is_null($row['service_category'])
        )
        // Initialize variables
        {
            $firstLetterFirstName = '';
        }
        $firstLettersOthernames = '';
        // Calculate initials
        if (!empty($row['first_name'])) {
            $firstLetterFirstName = substr($row['first_name'], 0, 1);
        }
        if (!empty($row['othernames'])) {
            $othernames = explode(' ', $row['othernames']);
            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }
        $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($row['surname']);
        // Adjust mobile number format if necessary
        if (strlen($row['mobile_no']) === 9 && is_numeric($row['mobile_no'])) {
            $row['mobile_no'] = '0' . $row['mobile_no'];
        }
        // Set default service category if not 'OFFICER'
        $row['service_category'] = ($row['service_category'] !== 'OFFICER') ? 'SOLDIER' : $row['service_category'];
        // Map gender values
        $mappedGender = '';
        if ($row['gender'] == 'MALE' || $row['gender'] == 'FEMALE') {
            $mappedGender = $row['gender'];
        } elseif ($row['gender'] == 'M') {
            $mappedGender = 'MALE';
        } elseif ($row['gender'] == 'F') {
            $mappedGender = 'FEMALE';
        } else {
            $mappedGender = $row['gender'];
        }
        // Set default email if not provided
        $row['email'] = $row['email'] ?? '';
        // Create Personnel object
        return new Personnel([
            'svcnumber' => $row['svcnumber'],
            'surname' => $row['surname'],
            'first_name' => $row['first_name'],
            'othernames' => $row['othernames'],
            'rank_id' => $row['rank_id'], // Ensure rank_id is provided in your data
            'initial' => $initials,
            'gender' => $mappedGender,
            'blood_group' => $row['blood_group'],
            'arm_of_service' => 1,
            'mobile_no' => $row['mobile_no'],
            'email' => $row['email'],
            'service_category' => $row['service_category'],
            'created_at' => now(),
            'created_by' => Auth::user() ? Auth::user()->id : null,
        ]);
    }

    // public function model(array $row)
    // {
    //     if (
    //         empty($row['svcnumber']) || empty($row['surname']) || empty($row['first_name']) ||
    //         empty($row['othernames']) || empty($row['gender']) || empty($row['blood_group']) ||
    //         empty($row['arm_of_service']) || is_null($row['mobile_no']) ||
    //         is_null($row['service_category'])
    //     ) {
    //         return null;
    //     }

    //     $row['status'] = 'ACTIVE'; // Set default status to 'ACTIVE'

    //     $firstLetterFirstName = substr($row['first_name'], 0, 1);
    //     $firstLettersOthernames = '';
    //     if (!empty($row['othernames'])) {
    //         $othernames = explode(' ', $row['othernames']);
    //         foreach ($othernames as $othername) {
    //             $firstLettersOthernames .= substr($othername, 0, 1);
    //         }
    //     }
    //     $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($row['surname']);
    //     if (strlen($row['mobile_no']) === 9 && is_numeric($row['mobile_no'])) {
    //         $row['mobile_no'] = '0' . $row['mobile_no'];
    //     }
    //     $row['service_category'] = ($row['service_category'] !== 'OFFICER') ? 'SOLDIER' : $row['service_category'];
    //     $rankId = $row['rank_id'];
    //     if ($row['gender'] == 'MALE' || $row['gender'] == 'FEMALE') {
    //         $mappedGender = $row['gender'];
    //     } elseif ($row['gender'] == 'M') {
    //         $mappedGender = 'MALE';
    //     } elseif ($row['gender'] == 'F') {
    //         $mappedGender = 'FEMALE';
    //     } else {
    //         $mappedGender = $row['gender'];
    //     }

    //     $row['email'] = $row['email'] ?? '';
    //     return new Personnel([
    //         'svcnumber' => $row['svcnumber'],
    //         'surname' => $row['surname'],
    //         'first_name' => $row['first_name'],
    //         'othernames' => $row['othernames'],
    //         'rank_id' => $rankId,
    //         'initial' => $initials,
    //         'gender' => $mappedGender,
    //         'blood_group' => $row['blood_group'],
    //         'arm_of_service' => 1,
    //         'mobile_no' => $row['mobile_no'],
    //         'email' => $row['email'],
    //         'service_category' => $row['service_category'],
    //         'status' => $row['status'], // Status set to 'ACTIVE'
    //         'created_at' => now(),
    //         'created_by' => Auth::user() ? Auth::user()->id : null,
    //     ]);
    // }

    public function chunkSize(): int
    {
        return 1000;
    }
}
