<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreateNotification extends Notification
{
    use Queueable;
    private $msg,$user_id,$vendor_id,$link,$order_id;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order_id,$user_id,$vendor_id,$msg,$link)
    {
        $this->msg = $msg;
        $this->user_id = $user_id;
        $this->vendor_id = $vendor_id;
        $this->link = $link;
        $this->order_id = $order_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
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
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'msg' => $this->msg,
            'user_id' => $this->user_id,
            'vendor_id'=>$this->vendor_id,
            'link'=>route('restaurant.order.view',$this->order_id)
        ];
    }
}
