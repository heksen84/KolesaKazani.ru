<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPasswordNotification extends Notification {
    
    use Queueable;

    protected $token;

    public function __construct($token) {
        $this->token=$token;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail( $notifiable ) {
    return ( new MailMessage )
      ->from('admin@flix.kz')
      ->subject( 'Сброс пароля' )
      ->line( "Для сброса пароля нажмите на кнопку \"Сбросить пароль\"." )
      ->action( 'Сбросить пароль', url( "/password/reset/".$this->token) );
    }
    
    public function toArray($notifiable) {
        return [];
    }
}
