<?php

namespace App\Notifications\Posts;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostNeedsApproval extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Post $post)
    {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Post Needs Approval')
            ->line('A new post requires your approval.')
            ->line('Title: ' . $this->post->title)
            ->action('Review Post', url('/admin/posts/' . $this->post->id))
            ->line('Please review the content and take appropriate action.');
    }

    public function toArray($notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'author' => $this->post->user->name,
        ];
    }
}