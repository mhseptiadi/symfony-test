<?php

namespace Console\Services;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class EmailService
{
    public function sendEmail($to): void
    {
        echo "sending email \n";

        $transport = Transport::fromDsn('smtp://user:pass@smtp.gmail.com:587');
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from('test@example.com')
            ->to($to)
            ->subject('Order file result')
            ->attachFromPath('./out.csv');

        $mailer->send($email);
    }
}
