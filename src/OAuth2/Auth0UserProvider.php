<?php

namespace App\OAuth2;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Auth0UserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    public function loadUserByIdentifier($identifier)
    {
        return null;
    }

    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    public function supportsClass(string $class)
    {
        return Auth0User::class === $class;
    }

    public function loadUserByUsername(string $username)
    {
        return null;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        return new Auth0User($response->getData());
    }
}
