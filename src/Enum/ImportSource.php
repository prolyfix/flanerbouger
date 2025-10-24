<?php
namespace App\Enum;

enum ImportSource: string
{
    case FILE = 'file';
    case URL = 'url';
    case API = 'api';
    case FEED = 'feed';

}