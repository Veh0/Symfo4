<?php

namespace App\EventListener;

use App\Entity\User;
use App\Event\RegisterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface {

    private $mailer;
    private $sender;

    public function __construct(\Swift_Mailer $mailer) {
        $this -> mailer = $mailer;
        $this -> sender = 'ff5d957cc0-e3309a@inbox.mailtrap.io';
    }

    public function displayRegistrationMessage(RegisterEvent $e) {
        /** @var User $user */
        $user = $e -> getUser();


        $subject = "YEAH";
        $body = "Yo ".$user -> getPseudo()."! Bienvenue";

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom($this -> sender)
            ->setTo($user -> getMail())
            ->setBody($body);

        $this -> mailer -> send($message);

    }

    static public function getSubscribedEvents() {
        return [
            RegisterEvent::NAME => [
                'displayRegistrationMessage' , -10
            ]
        ];
    }
}