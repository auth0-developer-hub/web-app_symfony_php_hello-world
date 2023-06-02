<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutListener
{
    private string $domain;
    private string $clientId;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(string $domain, string $clientId, UrlGeneratorInterface $urlGenerator)
    {
        $this->domain = $domain;
        $this->clientId = $clientId;
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke(LogoutEvent $event)
    {
        $event->setResponse(new RedirectResponse($this->getAuth0LogoutUrl(
            $this->urlGenerator->generate('home', [], UrlGeneratorInterface::ABSOLUTE_URL)
        )));
    }

    private function getAuth0LogoutUrl(string $redirectUri): string
    {
        return sprintf(
            'https://%s/v2/logout?client_id=%s&returnTo=%s',
            $this->domain,
            $this->clientId,
            $redirectUri
        );
    }
}
