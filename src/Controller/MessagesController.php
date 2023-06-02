<?php

namespace App\Controller;

use App\OAuth2\Auth0User;
use App\Service\MessageServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\ClientException;

class MessagesController extends AbstractController
{
    #[Route('/public', name: 'public_message')]
    public function publicMessage(MessageServiceInterface $messageService): Response
    {
        return $this->render('pages/message.html.twig', [
            'messageType' => 'Public',
            'description' => '<strong>Any visitor can access this page.</strong>',
            'response' => $messageService->getPublicMessage()
        ]);
    }

    #[Route('/protected', name: 'protected_message')]
    public function protectedMessage(MessageServiceInterface $messageService): Response
    {
        return $this->render('pages/message.html.twig', [
            'messageType' => 'Protected',
            'description' => '<strong>Only authenticated users can access this page.</strong>',
            'response' => $messageService->getProtectedMessage()
        ]);
    }

    #[Route('/admin', name: 'admin_message')]
    public function adminMessage(MessageServiceInterface $messageService): Response
    {
        /**@var Auth0User $user*/
        $user = $this->getUser();
        $response = null;

        try {
            $response = $messageService->getAdminMessage($user->getAccessToken());
        } catch (ClientException  $ex) {
            $response = json_decode($ex->getResponse()->getContent(false), true);
        }

        return  $this->render('pages/message.html.twig', [
            'messageType' => 'Admin',
            'description' => '<strong>
            Only authenticated users with the <code>read:admin-messages</code> permission should access this page.
            </strong>',
            'response' => $response
        ]);
    }
}
