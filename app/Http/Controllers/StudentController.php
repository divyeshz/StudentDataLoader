<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use App\Traits\JsonResponseTrait;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

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

    public function export(Request $request)
    {

        // Validate the uploaded file
        $request->validate([
            'export_type'       => 'required|string|in:file,class',
            'export_value' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->export_type === 'file') {
                        // Validate file extensions
                        if (!in_array(pathinfo($value, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv'])) {
                            $fail('The ' . $attribute . ' must have .xlsx, .xls, or .csv extension.');
                        }
                    } elseif ($request->export_type === 'class') {
                        // Validate numeric value between 1 and 12
                        if (!is_numeric($value) || $value < 1 || $value > 12) {
                            $fail('The ' . $attribute . ' must be a numeric value between 1 and 12.');
                        }
                    }
                }
            ],
            'export_filename'   => 'required|string',
            'export_filetype'   => 'required|in:.xlsx,.xls,.csv',
        ]);

        $export_filename = $request->export_filename . $request->export_filetype;

        $export = new StudentExport($request);
        return Excel::download($export,  $export_filename);
    }
}
