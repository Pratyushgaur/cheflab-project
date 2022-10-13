<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductReviewNotification extends Notification
{
    use Queueable;

    var $product_id,$sender_name,$msg;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product_id,$sender_name,$msg)
    {
        $this->product_id=$product_id;
        $this->sender_name=$sender_name;
        $this->msg=$msg;
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
            'msg'=>$this->msg,
            'sender_name'=>$this->sender_name,
            'link'=>route('restaurant.product.list')
        ];
    }
}
