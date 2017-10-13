<?php
declare(strict_types=1);

namespace App;

use Twig\Environment;

class Mailer
{
    private $swiftMailer;
    private $twig;

    public function __construct(\Swift_Mailer $swiftMailer, Environment $twig)
    {
        $this->swiftMailer = $swiftMailer;
        $this->twig = $twig;
    }

    public function sendRegistrationMail(string $recipient, array $data): void
    {
        $this->sendMail('registration.twig', $recipient, $data);
    }

    // way more mail functions...

    private function sendMail(string $template, string $recipient, array $data): void
    {
        $template = $this->twig->load($template);

        $subject = $template->renderBlock('subject', $data);
        $htmlContent = $template->renderBlock('html_content', $data);
        $textContent = $template->renderBlock('text_content', $data);

        /** @var \Swift_Message $message */
        $message = $this->swiftMailer->createMessage();
        $message
            ->setTo($recipient)
            ->setFrom('noreply@example.org')
            ->setSubject($subject)
            ->setBody($textContent, 'text/plain')
            ->addPart($htmlContent, 'text/html');

        $this->swiftMailer->send($message);
    }
}
