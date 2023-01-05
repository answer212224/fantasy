<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class GameNotification extends Notification
{
    use Queueable;

    public function __construct()
    { }

    public function via($game)
    {
        return ['slack'];
    }

    public function toSlack($game)
    {

        return (new SlackMessage)
            ->content($game->gamePlayers->toJson());
    }
}
