<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class LogNotificationsSent
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
    public function handle(NotificationSent $event): void
    {
        $to = $event->notifiable->email ?? 'desconhecido';
        $subject = method_exists($event->notification, 'toMail')
            ? $event->notification->toMail($event->notifiable)->subject
            : 'Sem assunto';

        Log::channel('emails')->info('Notificação enviada', [
            'to' => $to,
            'subject' => $subject,
            'type' => get_class($event->notification),
        ]);
    }
}
