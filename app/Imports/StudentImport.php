<?php

namespace App\Imports;

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
        return new Student([
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
        ]);
    }
}
