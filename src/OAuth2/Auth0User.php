<?php

namespace App\OAuth2;

use Symfony\Component\Security\Core\User\UserInterface;

class Auth0User implements UserInterface
{
    private array $payload;
    private string $accessToken;

    public function __construct(string $accessToken, array $payload)
    {
        $this->accessToken = $accessToken;
        $this->payload = $payload;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getUserIdentifier()
    {
        return $this->payload['sub'];
    }

    public function getRoles()
    {
        return ['ROLE_USER', 'ROLE_OAUTH_USER'];
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        return true;
    }

    public function getUsername()
    {
        return $this->payload['nickname'];
    }
}
