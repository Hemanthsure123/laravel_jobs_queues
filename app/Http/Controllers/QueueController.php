<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function showForm()
    {
        return view('queue-form');
    }

    public function processForm(Request $request)
    {
        $email = $request->input('email');

        // Dispatch the job to the queue
        SendEmailJob::dispatch($email);

        return 'Email queued successfully! Check your Mailtrap inbox in a bit.';
    }
}