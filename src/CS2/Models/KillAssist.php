<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class KillAssist extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<assister>'.CommonPatterns::IDENTITY_INNER.') '
        .'assisted killing (?P<killed>'.CommonPatterns::IDENTITY_INNER.')/';

    public string $type = 'KillAssist';

    public Carbon $timestamp;

    public PlayerIdentity $assister;

    public PlayerIdentity $killed;

    public function __construct(array $matches)
    {
        $assisterString = $matches['assister'];
        $killedString = $matches['killed'];
        unset($matches['assister'], $matches['killed']);

        parent::__construct($matches);

        $this->assister = PlayerIdentity::fromString($assisterString);
        $this->killed = PlayerIdentity::fromString($killedString);
    }
}
