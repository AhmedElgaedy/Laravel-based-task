<?php

namespace App\Jobs\Posts;

use App\Models\Post;
use App\Notifications\Posts\PostNeedsApproval;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPostApproval implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private Post $post)
    {}

    public function handle(): void
    {
        User::whereHas('roles', fn($q) => $q->where('slug', 'admin'))
            ->each(fn($admin) => $admin->notify(new PostNeedsApproval($this->post)));
    }
}