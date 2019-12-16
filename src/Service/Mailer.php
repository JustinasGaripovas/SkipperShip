<?php


namespace App\Service;


use App\Entity\Client;
use App\Entity\Courier;
use App\Entity\User;
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

    public function sendInquireToClient(User $client, string $message)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('SkipperShipHelp@gmail.com')
            ->setTo($client->getEmail())
            ->setBody(
                $this->environment->render(
                    'email/template.html.twig',
                    [
                        'message' => $message,
                        'user' => $client->getUsername(),
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
                        'user' => $client->getUsername(),
                        'date' => new \DateTime()
                    ]
                ),
                'text/plain'
            );

        $this->mailer->send($message);

    }

    public function sendInquireToCourier(User $courier, string $message)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('SkipperShipHelp@gmail.com')
            ->setTo($courier->getEmail())
            ->setBody(
                $this->environment->render(
                    'email/template.html.twig',
                    [
                        'message' => $message,
                        'user' => $courier->getUsername(),
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
                        'user' => $courier->getUsername(),
                        'date' => new \DateTime()
                    ]
                ),
                'text/plain'
            );

        $this->mailer->send($message);
    }

    public function sendInquireToAdmin(string $message, string $from, string $to = 'SkipperShipHelp@gmail.com')
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