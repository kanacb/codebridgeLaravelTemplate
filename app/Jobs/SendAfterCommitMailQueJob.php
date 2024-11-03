<?php

namespace App\Jobs;

use App\Mail\AfterCommitMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAfterCommitMailQueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emailData;

    /**
     * Create a new job instance.
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $recipients = json_decode($this->emailData['recipients']);
        Log::emergency($recipients);
        if (is_array($recipients))
            foreach ($recipients as $to) {
                Mail::to("kana@cloudbasha.com")->send(new AfterCommitMail($this->emailData));
            }
    }
}
