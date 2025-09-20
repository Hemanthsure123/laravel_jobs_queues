<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;  // We'll pass the email address here

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function handle(): void
    {
        Mail::raw('This is a test email from your queue!', function ($message) {
            $message->to($this->email)
                    ->subject('Queued Email Test');
        });
    }
}