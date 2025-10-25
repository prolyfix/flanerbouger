<?php

namespace App\Message;


final class StartImport
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

     public function __construct(
         public readonly int $id, public readonly ?string $next = null
     ) {
    }
}
