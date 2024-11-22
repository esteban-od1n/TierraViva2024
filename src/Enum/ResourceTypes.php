<?php

namespace App\Enum;

enum ResourceTypes: string
{
    case NEWS = "new";
    case VIDEO = "video";
    case BOOK = "book";
    case DOCUMENTARY = "documentary";
}
