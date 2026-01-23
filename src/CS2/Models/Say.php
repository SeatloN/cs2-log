<?php

namespace CSLog\CS2\Models;

use CSLog\CS2\CommonPatterns;

class Say extends SayBase
{
    public string $type = 'Say';

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<player>'.CommonPatterns::IDENTITY_INNER.') '
        .'say "(?P<text>.*)"/';
}
