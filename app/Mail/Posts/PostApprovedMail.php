<?php

namespace App\Mail\Posts;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Post $post
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Post Has Been Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.posts.approved',
        );
    }
}