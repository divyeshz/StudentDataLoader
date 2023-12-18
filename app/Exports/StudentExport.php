<?php

namespace App\Exports;


use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function collection()
    {

        return Student::select([
            'roll_no',
            'name',
            'class',
            'email',
            'gender',
            'guardian_name',
            'guardian_email',
            'city',
            'state',
            'pincode',
        ])->where('class', $this->request['export_value'])->orWhere('import_filename', $this->request['export_value'])->get();
    }

    public function headings(): array
    {
        return [
            'Roll No',
            'Name',
            'Class',
            'Email',
            'Gender',
            'Guardian Name',
            'Guardian Email',
            'City',
            'State',
            'Pincode',
        ];
    }
}
