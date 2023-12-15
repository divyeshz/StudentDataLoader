<?php

namespace App\Jobs;

use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Bus\Queueable;
use App\Mail\CustomScheduleMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendScheduledEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $student;

    /**
     * Create a new job instance.
     */
    public function __construct($student)
    {
        $this->student = $student;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $student = $this->student;

        $pdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $pdf->setOptions($options);

        $pdfContent = view('emails.results', compact('student'))->render();


        $pdf->loadHtml($pdfContent);
        $pdf->render();

        $publicPath = env('PUBLIC_PATH', 'public');

        // Save PDF to storage (optional)
        $pdfPath = $publicPath . '/reports/' . $student->id . '_report.pdf';
        Storage::put($pdfPath, $pdf->output());


        Mail::to($this->student->email)->send(new CustomScheduleMail($this->student, $pdfPath));
    }
}
