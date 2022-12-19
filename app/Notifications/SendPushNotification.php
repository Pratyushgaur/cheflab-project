<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendPushNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $fcmTokens;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $message, $fcmTokens)
    {
        $this->title     = $title;
        $this->message   = $message;
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
       return ['firebase'];
    }

   public function toFirebase($notifiable)
   {
        
       return (new FirebaseMessage)
           ->withTitle($this->title)
           ->withBody($this->message)
//           ->withImage('https://firebase.google.com/images/social.png')
//           ->withIcon('https://seeklogo.com/images/F/firebase-logo-402F407EE0-seeklogo.com.png')
           ->withSound('default')
           ->withClickAction('https://www.google.com')
           ->withPriority('high')
           ->withAdditionalData([
               'msg_type' => 'info',
               'link' => 'https://www.google.com'
           ])
           ->withPriority('high')->asMessage($this->fcmTokens);
   }
}
