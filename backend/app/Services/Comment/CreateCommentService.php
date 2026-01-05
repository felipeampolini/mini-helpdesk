<?php

namespace App\Services\Comment;

use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\Ticket;
use Auth;

class CreateCommentService
{
    public function execute(Ticket $ticket, string $comment): Comment
    {
        $comment = $ticket->comments()->create([
            'body'    => $comment,
            'user_id'=> Auth::id(),
        ]);

        event(new CommentCreated($comment));

        return $comment;
    }
}
