<?php

namespace App\Listeners\Users;

use App\Events\UserRegistered;
use App\Mail\Users\WelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    public function handle(UserRegistered $event): void
    {
        Mail::to($event->user->email)
            ->queue(new WelcomeMail($event->user));
    }
}