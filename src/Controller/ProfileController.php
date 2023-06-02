<?php

namespace App\Controller;

use App\OAuth2\Auth0User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function profile(): Response
    {
        /**@var Auth0User $user*/
        $user = $this->getUser();

        return $this->render(
            'pages/profile.html.twig',
            [
                'profile' => $user->getPayload()
            ]
        );
    }
}
