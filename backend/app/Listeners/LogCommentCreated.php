<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LogCommentCreated
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
    public function handle(CommentCreated $event): void
    {
        Log::info("O usuário [ID: {$event->comment->user->id}, Email: {$event->comment->user->email}] comentou no ticket #{$event->comment->ticket->id}", [
            'comment' => $event->comment->body,
        ]);
    }
}
