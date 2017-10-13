<?php
declare(strict_types=1);

namespace App\Controller;

use App\Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class MailingController
{
    /**
     * @Route("registration", name="mail_registration", methods={"POST"})
     */
    public function registrationAction(Request $request, Mailer $mailer): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data) && !array_key_exists('recipient', $data)) {
            throw new BadRequestHttpException('Request payload must be an array and contain "recipient" key.');
        }

        $mailer->sendRegistrationMail($data['recipient'], $data);

        return Response::create();
    }

    // way more mailing endpoints...
}
