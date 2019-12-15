<?php


namespace App\Service;


use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;

class Mailer
{
    /** @var \Swift_Mailer $mailer */
    private $mailer;

    private $environment;


    public function __construct(Environment $environment,\Swift_Mailer $mailer)
    {
        $this->environment = $environment;
        $this->mailer = $mailer;
    }

    public function sendInquireToAdmin(string $message, string $from, string $to = 'justelis911@gmail.com')
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('SkipperShipHelp@gmail.com')
            ->setTo($to)
            ->setBody(
                $this->environment->render(
                    'email/template.html.twig',
                    [
                        'message' => $message,
                        'user' => $from,
                        'date' => new \DateTime()
                    ]
                ),
                'text/html'
            )
            ->addPart(
                $this->environment->render(
                // templates/emails/registration.txt.twig
                    'email/template.html.twig',
                    [
                        'message' => $message,
                        'user' => $from,
                        'date' => new \DateTime()
                    ]
                ),
                'text/plain'
            );

        $this->mailer->send($message);
    }

}