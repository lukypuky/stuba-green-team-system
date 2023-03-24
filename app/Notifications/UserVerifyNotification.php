<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

class UserVerifyNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;
    public $user;          
    
    /**
     * Create a new notification instance.
         *
         * @return void
         */
        public function __construct()
        {
            
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
    
        /**
         * Get the mail representation of the notification.
         *
         * @param  mixed  $notifiable
         * @return \Illuminate\Notifications\Messages\MailMessage
         */
        public function toMail($notifiable)
        {
            return (new MailMessage)->subject('Overenie emailovej adresy')->view(
                'Emails.verifyEmail',
                [
                    'actionText' => 'Overiť emailovú adresu',
                    'actionUrl' => $this->verificationUrl($notifiable), //verificationUrl required for the verification link
                ]);
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
                //
            ];
        }
        
    }
?>