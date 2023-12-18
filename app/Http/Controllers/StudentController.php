<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\StudentExport;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class StudentController extends Controller
{
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

                    return error(422, ['errors' => $failures]);
                }

                return success(200, __('custom.student.insert'), $request->all());
            } catch (ValidationException $e) {
                $failures = $e->failures();

                return error(422, ['errors' => $failures]);
            } catch (\Exception $e) {
                return error(500, ['error' => $e->getMessage()]);
            }
        }

        return error(415, __('custom.student.invalid_file'));
    }

    public function export(Request $request)
    {

        // Validate
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
