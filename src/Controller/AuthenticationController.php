<?php

namespace App\Controller;

use HWI\Bundle\OAuthBundle\Security\OAuthUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationController extends AbstractController
{
    private const AUTH0_SERVICE_KEY = 'auth0';

    private OAuthUtils $oAuthUtils;

    public function __construct(OAuthUtils $oAuthUtils)
    {
        $this->oAuthUtils = $oAuthUtils;
    }

    #[Route('/login', name: 'login')]
    public function login(Request $request): Response
    {
        return $this->redirect(
            $this->oAuthUtils->getAuthorizationUrl($request, self::AUTH0_SERVICE_KEY)
        );
    }

    #[Route('/signup', name: 'signup')]
    public function signup(Request $request): Response
    {
        return $this->redirect(
            $this->oAuthUtils->getAuthorizationUrl(
                $request,
                self::AUTH0_SERVICE_KEY,
                null,
                [
                    'screen_hint' => 'signup'
                ]
            )
        );
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        throw new AuthenticationException('The firewall must intercept this action.');
    }
}
