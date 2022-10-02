<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class ProductCreatedNotification extends Notification
{
    use Queueable;

    private  $product_id,$msg,$sender_name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product_id,$sender_name)
    {
        $this->product_id=$product_id;
        $this->sender_name=$sender_name;
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
            'msg'=>\Auth::guard('vendor')->user()->name." added new product.",
            'sender_name'=>$this->sender_name,
            'link'=>route('admin.vendor.pendigProduct')
        ];
    }
}
