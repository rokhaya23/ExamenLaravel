<?php

namespace App\Notifications;

use App\Models\Conge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvelleDemandeCongeNotification extends Notification
{
    use Queueable;
    public $demandeConge;

    /**
     * Create a new notification instance.
     */
    public function __construct(Conge $demandeConge)
    {
        $this->demandeConge = $demandeConge;

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
        return (new MailMessage)
            ->line('Une nouvelle demande de congé a été soumise.')
            ->line('Type de congé: ' . $this->demandeConge->type_conge)
            ->line('Date de début: ' . $this->demandeConge->date_debut)
            ->line('Date de fin: ' . $this->demandeConge->date_fin)
            ->action('Voir la demande de congé', route('demande_conge.show', $this->demandeConge))
            ->line('Merci de traiter cette demande.');
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
