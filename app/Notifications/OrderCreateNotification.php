<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class OrderCreateNotification extends Notification
{
    use Queueable;
    protected $fcmTokens, $title;
    private $msg, $sender_name, $vendor_id, $link, $order_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order_id, $sender_name, $title, $msg, $link, $fcmTokens)
    {
        $this->title       = $title;
        $this->msg         = $msg;
        $this->sender_name = $sender_name;
        // $this->vendor_id = $vendor_id;
        $this->link      = $link;
        $this->order_id  = $order_id;
        $this->fcmTokens = $fcmTokens;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'
               , 'firebase'
        ];
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
            'msg' => $this->msg,
            'sender_name' => $this->sender_name,
            // 'vendor_id'=>$this->vendor_id,
            'link' => route('restaurant.order.view', $this->order_id)
        ];
    }

   public function toFirebase($notifiable)
   {

       if ($this->fcmTokens != ''){
        $token []= $this->fcmTokens;
        $res = sendNotification($this->title,$this->msg,$token,['msg_type' => 'info','link' => $this->link]);
        
        var_dump($res);
        //var_dump($res);
        //    $r =  (new FirebaseMessage)
        //        ->withTitle($this->title)
        //        ->withBody($this->msg)
        //        ->withSound('default')
        //        ->withClickAction($this->link)
        //        ->withAdditionalData([
        //            'msg_type' => 'info',
        //            'link' => $this->link
        //        ])
        //        ->withPriority('high')->asMessage($this->fcmTokens);
        //     return $r;

       }

       else
           return false;
   }
}
