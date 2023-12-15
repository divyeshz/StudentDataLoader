<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\StudentImport;
use App\Traits\JsonResponseTrait;

class StudentController extends Controller
{
    use JsonResponseTrait;
    public function import(Request $request)
    {

        // Validate the uploaded file
        $request->validate([
            'students'     => 'required|mimes:xlsx,xls,csv',
        ]);

        // Check if the request has a file attached
        if ($request->hasFile('students')) {

            // Process the uploaded file
            $file = $request->file('students');
            $filename = $file->getClientOriginalName();

            // Import the file data using StudentImport
            try {
                $import = new StudentImport($filename);
                Excel::import($import, $file);

                // Check for validation failures after the import
                if ($import->failures()) {
                    $failures = $import->failures();

                    return response()->json(['errors' => $failures], 422);
                }

                return response()->json(['message' => 'File imported successfully']);
            } catch (ValidationException $e) {
                $failures = $e->failures();

                return response()->json(['errors' => $failures], 422);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return $this->error(400, 'Invalid file or no file uploaded!!!');
    }
}
