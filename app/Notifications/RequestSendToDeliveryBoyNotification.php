<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class RequestSendToDeliveryBoyNotification extends Notification
{
    use Queueable;
    protected $fcmTokens, $title;
    private $msg, $accept_link, $sender_name, $decline_link;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $msg, $sender_name, $fcmTokens, $accept_link, $decline_link)
    {
        $this->title        = $title;
        $this->fcmTokens    = $fcmTokens;
        $this->msg          = $msg;
        $this->sender_name  = $sender_name;
        $this->accept_link  = $accept_link;
        $this->decline_link = $decline_link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'firebase'];
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
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
            'msg'          => $this->msg,
            'sender_name'  => $this->sender_name,
            'link'         => '',
            'accept_link'  => $this->accept_link,
            'decline_link' => $this->decline_link
        ];
    }

    public function toFirebase($notifiable)
    {
        if ($this->fcmTokens != '') {
            return (new FirebaseMessage)
                ->withTitle($this->title)
                ->withBody($this->msg)
                ->withSound('default')
                ->withClickAction( $this->accept_link)
                ->withAdditionalData([
                    'msg_type'     => 'info',
                    'link'         => '',
                    'accept_link'  => $this->accept_link,
                    'decline_link' => $this->decline_link
                ])
                ->withPriority('high')->asMessage($this->fcmTokens);

        } else
            return false;
    }
}
