<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // Check if the request has a file attached
        if ($request->hasFile('students') && $request->file('students')->getClientOriginalExtension() == 'xlsx') {

            $data = Excel::import(new StudentImport, $request->file('students'));

            return response()->json(['message' => 'Data Insert successfully']);
        }

        return response()->json(['message' => 'Invalid file or no file uploaded'], 400);
    }
}
