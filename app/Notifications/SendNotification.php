<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class SendNotification extends Notification
{
    use Queueable;

    public function __construct($reorder)
    {
        $this->reorder = $reorder;
    }

    public function via($filtered)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $reorder = collect($this->reorder)->toJson();
        return (new SlackMessage)
            ->content($reorder);
    }
}
