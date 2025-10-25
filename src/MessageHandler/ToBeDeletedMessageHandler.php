<?php

namespace App\MessageHandler;

use App\Message\ToBeDeletedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ToBeDeletedMessageHandler{
    public function __invoke(ToBeDeletedMessage $message): void
    {
        // do something with your message
    }
}
