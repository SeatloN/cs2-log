<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\CS2\ValueObjects\Vector3;
use CSLog\Model;

class BombKill extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<killed>'.CommonPatterns::IDENTITY_INNER.') '
        .CommonPatterns::KILLED_VECTOR.' was killed by the bomb/';

    public string $type = 'BombKill';

    public Carbon $timestamp;

    public PlayerIdentity $killed;

    public Vector3 $killedPos;

    public function __construct(array $matches)
    {
        $killedString = $matches['killed'];
        unset($matches['killed']);

        parent::__construct($matches);

        $this->killed = PlayerIdentity::fromString($killedString);
        $this->killedPos = Vector3::fromMatches($matches, 'killed');
    }
}
