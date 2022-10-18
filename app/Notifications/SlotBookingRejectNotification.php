<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SlotBookingRejectNotification extends Notification
{
    use Queueable;
    private $msg, $link, $sender_name;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($msg, $sender_name, $link)
    {

        $this->msg         = $msg;
        $this->sender_name = $sender_name;
        $this->link        = $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ 'database' ];
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
//            ->from('barrett@example.com', 'Barrett Blair')
            ->subject('Banner promotion request rejected')
            ->greeting('Hello!')
            ->line($this->msg)
//            ->lineIf($this->amount > 0, "Amount paid: {$this->amount}")
//            ->action('Make a payment', $this->link)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'msg'         => $this->msg,
            'sender_name' => $this->sender_name,
            'link'        => $this->link

        ];
    }
}
