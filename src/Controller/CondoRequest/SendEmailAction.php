<?php

namespace App\Controller\CondoRequest;

use App\Entity\User;
use App\Service\CondoRequest\CondoRequestSendEmailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SendEmailAction
{
    public function __construct(private CondoRequestSendEmailService $sendEmailService)
    {
    }

    public function __invoke(Request $request, User $user)
    {
        $responseData = \json_decode($request->getContent(), true);

//        if (null === $receiver = $responseData['receiver']) {
//            throw new BadRequestHttpException('Receiver param is mandatory');
//        }

        $this->sendEmailService->__invoke($responseData['receiver'], $user->getEmail());
    }
}