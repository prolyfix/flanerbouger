<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('async')]
final class SendEmailMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

     public function __construct(
         public readonly string $templatePath,
         public readonly array $context = [],
         public readonly string $to,
         public readonly string $subject
     ) {
     }
}
