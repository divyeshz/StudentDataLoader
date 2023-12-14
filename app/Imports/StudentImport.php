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
            "roll_no" => $rows["roll_no"],
            "name" => $rows["name"],
            "class" => $rows["class"],
            "email" => $rows["email"],
            "gender" => $rows["gender"],
            "guardian_name" => $rows["guardian_name"],
            "guardian_email" => $rows["guardian_email"],
            "city" => $rows["city"],
            "state" => $rows["state"],
            "pincode" => $rows["pincode"],
        ];

        // Insert data into the Student table
        $student = Student::create($studentData);

        $total = $this->totalMarks($rows);

        $percentage = $this->calculatePercentage($rows);

        // Extract data for the Result table
        $resultData = [
            "std_id" => $student->id,
            "maths" => $rows["maths"],
            "science" => $rows["science"],
            "hindi" => $rows["hindi"],
            "english" => $rows["english"],
            "social_science" => $rows["social_science"],
            "computer" => $rows["computer"],
            "arts" => $rows["arts"],
            "total" => $total,
            "percentage" => $percentage,
        ];

        // Insert data into the Result table
        Result::create($resultData);
    }

    private function totalMarks(array $rows)
    {
        $subjects = ['maths', 'science', 'hindi', 'english', 'social_science', 'computer', 'arts'];

        $obtainedMarks = 0;
        foreach ($subjects as $subject) {
            $obtainedMarks += isset($rows[$subject]) ? $rows[$subject] : 0;
        }
        return intval($obtainedMarks);
    }

    private function calculatePercentage(array $rows)
    {
        $subjects = ['maths', 'science', 'hindi', 'english', 'social_science', 'computer', 'arts'];
        $totalMarks = 0;
        $obtainedMarks = 0;

        foreach ($subjects as $subject) {
            $totalMarks += 100;
            $obtainedMarks += isset($rows[$subject]) ? $rows[$subject] : 0;
        }

        if ($totalMarks === 0) {
            return 0; // To avoid division by zero
        }

        return ($obtainedMarks / $totalMarks) * 100;
    }
}
