<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
use App\Traits\JsonResponseTrait;

class StudentController extends Controller
{
    use JsonResponseTrait;
    public function store(Request $request)
    {
        // Check if the request has a file attached
        if ($request->hasFile('students') && $request->file('students')->getClientOriginalExtension() == 'xlsx') {

            $data = Excel::import(new StudentImport, $request->file('students'));

            return $this->success(200, 'Students Insert successfully!!!');
        }

        return $this->error(400, 'Invalid file or no file uploaded!!!');
    }
}
