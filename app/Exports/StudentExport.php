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
        if ($this->request['export_type'] == 'class') {
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
            ])->where('class', $this->request['class'])->get();
        }

        if ($this->request['export_type'] == 'file') {
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
            ])->where('import_filename', $this->request['filename'])->get();
        }
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
