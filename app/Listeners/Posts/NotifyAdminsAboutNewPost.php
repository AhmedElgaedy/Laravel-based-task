<?php

namespace App\Listeners\Posts;

use App\Events\Posts\PostSubmitted;
use App\Jobs\Posts\ProcessPostApproval;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminsAboutNewPost implements ShouldQueue
{
    public function handle(PostSubmitted $event): void
    {
        ProcessPostApproval::dispatch($event->post);
    }
}