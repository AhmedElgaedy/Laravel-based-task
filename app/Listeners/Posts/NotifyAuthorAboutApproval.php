<?php

namespace App\Listeners\Posts;

use App\Events\PostApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAuthorAboutApproval
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostApproved $event): void
    {
        //
    }
}
