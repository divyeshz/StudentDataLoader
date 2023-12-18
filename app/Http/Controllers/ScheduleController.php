<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomSchedule;

class ScheduleController extends Controller
{
    public function import(Request $request)
    {
        // validation
        $request->validate([
            'schedule_type'     => 'required|string|in:student,class',
            'schedule_value' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->schedule_type === 'class') {
                        // Validate numeric value between 1 and 12
                        if (!is_numeric($value) || $value < 1 || $value > 12) {
                            $fail('The ' . $attribute . ' must be a numeric value between 1 and 12.');
                        }
                    } elseif ($request->schedule_type === 'student') {
                        // Validate using regex pattern for student type
                        if (!preg_match('/^STD_\d{5}$/', $value)) {
                            $fail('The ' . $attribute . ' must match the pattern STD_XXXXX');
                        }
                    }
                }
            ],
            'datetime'          => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Create a record in CustomSchedule table
        CustomSchedule::create([
            'schedule_type'     => $request->schedule_type,
            'schedule_value'    => $request->schedule_value,
            'datetime'          => $request->datetime,
        ]);

        return success(200, 'Schedule Insert successfully!!!');
    }
}
