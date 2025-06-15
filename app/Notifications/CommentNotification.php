<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class CommentNotification extends Notification
{
    use Queueable;

    protected $fromUser;
    protected $postId;
    protected $body;

    public function __construct($fromUser, $postId, $body)
    {
        $this->fromUser = $fromUser;
        $this->postId = $postId;
        $this->body = $body;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'from_user_id' => $this->fromUser->id,
            'from_user_name' => $this->fromUser->username,
            'type' => 'comment',
            'post_id' => $this->postId,
            'body' => $this->body,
        ];
    }
}

