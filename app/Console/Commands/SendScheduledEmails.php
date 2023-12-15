<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\CustomSchedule;
use Illuminate\Console\Command;
use App\Jobs\SendScheduledEmailJob;

class SendScheduledEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-scheduled-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled emails at designated time';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $currentDateTime = Carbon::now();
        $scheduleds = CustomSchedule::where('is_send', 0)->get();

        foreach ($scheduleds as $scheduled) {
            $scheduledDateTime = Carbon::parse($scheduled->datetime);
            if (
                $scheduledDateTime->year === $currentDateTime->year &&
                $scheduledDateTime->month === $currentDateTime->month &&
                $scheduledDateTime->day === $currentDateTime->day &&
                $scheduledDateTime->hour === $currentDateTime->hour &&
                $scheduledDateTime->minute === $currentDateTime->minute
            ) {

                $scheduled->update(['status' => "schedule"]);

                if ($scheduled->schedule_type == 'class') {
                    // Send mail to the entire class
                    $students = Student::where('class', $scheduled->class)->get();
                    foreach ($students as $student) {
                        $scheduled->update(['status' => "in progress"]);
                        dispatch(new SendScheduledEmailJob($student));
                    }
                }

                if ($scheduled->schedule_type == 'student') {
                    // Send mail to the specific student
                    $student = Student::where('roll_no', $scheduled->std_roll_no)->first();
                    dispatch(new SendScheduledEmailJob($student));
                }
                $scheduled->update(['status' => "complete"]);
            }
        }
    }
}
