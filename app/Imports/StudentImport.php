<?php

namespace App\Imports;

use App\Models\Result;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $rows
     */
    public function model(array $rows)
    {
        // Extract data for the Student table
        $studentData = [
            "roll_no"        => $rows["roll_no"],
            "name"           => $rows["name"],
            "class"          => $rows["class"],
            "email"          => $rows["email"],
            "gender"         => $rows["gender"],
            "guardian_name"  => $rows["guardian_name"],
            "guardian_email" => $rows["guardian_email"],
            "city"           => $rows["city"],
            "state"          => $rows["state"],
            "pincode"        => $rows["pincode"],
        ];

        // Insert data into the Student table
        $student = Student::create($studentData);

        $percentageAndTotal = $this->calculatePercentageAndTotal($rows);
        $percentage         = $percentageAndTotal['percentage'];
        $total              = $percentageAndTotal['total'];
        $status             = $this->checkStudentStatus($percentage);

        // Extract data for the Result table
        $resultData = [
            "std_id"            => $student->id,
            "maths"             => $rows["maths"],
            "science"           => $rows["science"],
            "hindi"             => $rows["hindi"],
            "english"           => $rows["english"],
            "social_science"    => $rows["social_science"],
            "computer"          => $rows["computer"],
            "arts"              => $rows["arts"],
            "total"             => $total,
            "percentage"        => $percentage,
            "status"            => $status,
        ];

        // Insert data into the Result table
        Result::create($resultData);
    }

    private function calculatePercentageAndTotal(array $rows)
    {
        $subjects      = ['maths', 'science', 'hindi', 'english', 'social_science', 'computer', 'arts'];
        $totalMarks    = 0;
        $obtainedMarks = 0;

        foreach ($subjects as $subject) {
            $totalMarks    += 100;
            $obtainedMarks += isset($rows[$subject]) ? $rows[$subject] : 0;
        }

        if ($totalMarks === 0) {
            return 0; // To avoid division by zero
        }

        $percentage = ($obtainedMarks / $totalMarks) * 100;
        return ['percentage' => $percentage, 'total' => intval($obtainedMarks)];
    }

    private function checkStudentStatus($percentage)
    {
        if ($percentage >= 75) {
            return "First Class with Distinction";
        } elseif ($percentage >= 60) {
            return "First Class";
        } elseif ($percentage >= 50) {
            return "Second Class";
        } elseif ($percentage >= 40) {
            return "Pass";
        } else {
            return "Fail";
        }
    }
}
