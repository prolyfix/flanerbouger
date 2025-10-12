<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendEmailMessageHandler{
    public function __construct()
    {
    }
    public function __invoke(SendEmailMessage $message, MailerInterface $mailer): void
    {
        $templatedEmail  = new TemplatedEmail();
        $templatedEmail->to($message->to)
            ->subject($message->subject)
            ->htmlTemplate($message->templatePath)
            ->context($message->context);
        $mailer->send($templatedEmail);
        
    }
}
