<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileReference;
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

                return success(200, __('custom.student.insert'));
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
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->export_type === 'file') {
                        // Check if the value exists as a UUID in the FileReference table
                        if (!FileReference::where('id', $value)->exists()) {
                            $fail('The selected file does not exist.');
                        }
                    } elseif ($request->export_type === 'class') {
                        // Validate numeric value between 1 and 12
                        if (!is_numeric($value) || $value <= 1 || $value >= 12) {
                            $fail('The ' . $attribute . ' must be a numeric value between 1 and 12.');
                        }
                    } else {
                        $fail('Invalid export type.');
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
