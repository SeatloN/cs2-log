<?php

namespace CSLog\CS2\Models;

use CSLog\CS2\CommonPatterns;

class SayTeam extends SayBase
{
    public string $type = 'SayTeam';

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<player>'.CommonPatterns::IDENTITY_INNER.') '
        .'say_team "(?P<text>.*)"/';
}
