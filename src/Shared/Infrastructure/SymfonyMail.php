<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\MailInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class SymfonyMail implements MailInterface
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $to, string $subject, string $content): void
    {
        $email = new Email();
        $email->from('henrique@brokalia.com');
        $email->to($to);
        $email->subject($subject);
        $email->text($content);

        $this->mailer->send($email);
    }
}