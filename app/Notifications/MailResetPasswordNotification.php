<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPasswordNotification extends Notification
{
    use Queueable;

    protected $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token=$token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

   
    public function toMail( $notifiable ) {

    $link = url( "/password/reset/".$this->token);

    return ( new MailMessage )
      ->from('info@damelya.kz')
      ->subject( 'Сброс пароля' )
      ->line( "Для подтверждения сброса пароля нажмите на кнопку 'Сбросить пароль'" )
      ->action( 'Сбросить пароль', $link )
      ->line( 'Спасибки!' );

    }
    
    public function toArray($notifiable) {
        return [];
    }
}
