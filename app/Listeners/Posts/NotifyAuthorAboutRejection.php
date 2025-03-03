<?php

namespace App\Listeners\Posts;

use App\Events\PostRejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAuthorAboutRejection
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
    public function handle(PostRejected $event): void
    {
        //
    }
}
