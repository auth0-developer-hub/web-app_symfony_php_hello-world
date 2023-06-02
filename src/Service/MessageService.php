<?php

namespace App\Service;

use App\Models\Message;

class MessageService implements MessageServiceInterface
{
    public function getPublicMessage(): Message
    {
        return new Message("This is a public message.");
    }

    public function getProtectedMessage(): Message
    {
        return new Message("This is a protected message.");
    }

    public function getAdminMessage(): Message
    {
        return new Message("This is an admin message.");
    }
}
