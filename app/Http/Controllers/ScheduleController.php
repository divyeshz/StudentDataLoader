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
        // validation
        $request->validate([
            'schedule_type'     => 'required|string|in:student,class',
            'schedule_value'    => 'required|string',
            'datetime'          => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Create a record in CustomSchedule table
        CustomSchedule::create([
            'schedule_type'     => $request->schedule_type,
            'schedule_value'    => $request->schedule_value,
            'datetime'          => $request->datetime,
        ]);

        return $this->success(200, 'Schedule Insert successfully!!!');
    }
}
