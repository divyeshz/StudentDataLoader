<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\EmailsTrait;
use Illuminate\Http\Request;
use App\Models\CustomSchedule;
use App\Mail\CustomScheduleMail;
use App\Traits\JsonResponseTrait;

class ScheduleController extends Controller
{
    use JsonResponseTrait, EmailsTrait;
    public function import(Request $request)
    {
        $request->validate([
            'schedule_type'     => 'required|string|in:student,class',
            'datetime'          => 'required|date_format:Y-m-d H:i:s',
            'std_roll_no'       => 'required_if:schedule_type,student',
            'class'             => 'required_if:schedule_type,class',
        ]);

        // Create a record in custom_schedules table for the entire class
        CustomSchedule::create([
            'schedule_type' => $request->schedule_type,
            'datetime'      => $request->datetime,
            'std_roll_no'   => $request->std_roll_no,
            'class'         => $request->class,
        ]);

        return $this->success(200, 'Schedule Insert successfully!!!');
    }
}
