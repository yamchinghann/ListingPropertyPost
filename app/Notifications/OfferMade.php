<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferMade extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Offer $offer)//no need to initialize as laravel will do it
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];//specific how this notification should be delivered to the user.
        //can specific one or many different channels
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage //how to send Notification
    {
        return (new MailMessage)
            ->line("New offer ({$this->offer->amount}) was made for your listing")
            ->action(
                'See Your Listing',
                route('realtor.listing.show', ['listing' => $this->offer->listing_id])
            )
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        //there is this two array method which is used to specify what data would you like to save to the
        //database?
        return [
            'offer_id' => $this->offer->id,
            'listing_id' => $this->offer->listing_id,
            'amount' => $this->offer->amount,
            'bidder_id' => $this->offer->bidder_id
        ];
    }
}
