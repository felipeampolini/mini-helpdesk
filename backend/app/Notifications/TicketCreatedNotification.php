<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCreatedNotification extends Notification
{
    use Queueable;

    public Ticket $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('tickets.show', $this->ticket);

        return (new MailMessage)
            ->subject("Novo Ticket Criado: {$this->ticket->title}")
            ->greeting("Olá {$notifiable->name},")
            ->line("Seu ticket foi criado com sucesso.")
            ->line("Título: {$this->ticket->title}")
            ->line("Descrição: {$this->ticket->description}")
            ->line("Prioridade: ".ucfirst($this->ticket->priority))
            ->line("Status: ".ucfirst($this->ticket->status))
            ->action('Ver Ticket', $url)
            ->line('Obrigado por usar nosso sistema!')
            ->level("success");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
