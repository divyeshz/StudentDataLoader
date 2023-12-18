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

        $currentDateTime = Carbon::now()->format('Y-m-d H:i:00');
        $scheduleds = CustomSchedule::where('is_send', false)
            ->where('datetime', '=', $currentDateTime)
            ->get();

        foreach ($scheduleds as $scheduled) {

            $scheduled->update(['status' => config('constant.schedule.start')]);

            if ($scheduled->schedule_type == 'class') {

                // Send mail to the entire class
                $students = Student::where('class', $scheduled->schedule_value)->get();

                foreach ($students as $student) {
                    $scheduled->update(['status' => config('constant.schedule.progress')]);
                    dispatch(new SendScheduledEmailJob($student));
                }
            }

            if ($scheduled->schedule_type == 'student') {
                // Send mail to the specific student
                $student = Student::where('roll_no', $scheduled->schedule_value)->first();
                $scheduled->update(['status' => config('constant.schedule.progress')]);
                dispatch(new SendScheduledEmailJob($student));
            }
            $scheduled->update(['status' => config('constant.schedule.end')]);
            $scheduled->update(['is_send' => true]);
        }
    }
}
