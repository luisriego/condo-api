<?php

namespace App\Service\CondoRequest;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class CondoRequestSendEmailService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(string $receiver, string $sender)
    {
        $email = (new Email())
            ->from($sender)
            ->to($receiver)
            ->subject('Convite para o site do condomínio Matisse')
            ->html('<p>Por favor clique no link abaixo</p>');

        $this->mailer->send($email);
    }
}