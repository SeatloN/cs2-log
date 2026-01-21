<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class ConsoleSay extends Model
{
    public const PATTERN = '/"(?P<userName>.+)[<](?P<userId>\d+)[>]" say "(?P<text>.*)"/';

    public string $type = 'ConsoleSay';

    public string $userId;

    public string $userName;

    public string $text;
}
