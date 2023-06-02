<?php

namespace App\Service;

use App\Models\Message;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MessageService implements MessageServiceInterface
{
    private HttpClientInterface $client;
    private string $apiServerUrl;

    public function __construct(HttpClientInterface $client, string $apiServerUrl)
    {
        $this->client = $client;
        $this->apiServerUrl = $apiServerUrl;
    }

    public function getPublicMessage(): Message
    {
        return new Message("This is a public message.");
    }

    public function getProtectedMessage(): Message
    {
        return new Message("This is a protected message.");
    }

    public function getAdminMessage(string $accessToken): Message
    {
        $endpoint = ltrim($this->apiServerUrl, '/') . '/api/messages/admin';
        $response = $this->client->request('GET', $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);


        if ($response->getStatusCode() != Response::HTTP_OK) {
            throw new ClientException($response);
        }

        $body = json_decode($response->getContent(false), true);

        return new Message($body['text']);
    }
}
