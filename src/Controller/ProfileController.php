<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function profile(): Response
    {
        return $this->render(
            'pages/profile.html.twig',
            [
                'profile' => [
                    'nickname' => "Customer",
                    'name' => "One Customer",
                    'picture' => "https://cdn.auth0.com/blog/hello-auth0/auth0-user.png",
                    'updated_at' => "2021-05-04T21:33:09.415Z",
                    'email' => "customer@example.com",
                    'email_verified' => false,
                    'sub' => "auth0|12345678901234567890"
                ]
            ]
        );
    }
}
