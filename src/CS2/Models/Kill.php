<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\CS2\ValueObjects\Vector3;
use CSLog\Model;

class Kill extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<killer>'.CommonPatterns::IDENTITY_INNER.') '
        .CommonPatterns::KILLER_VECTOR.' '
        .'killed '
        .'(?P<killed>'.CommonPatterns::IDENTITY_INNER.') '
        .CommonPatterns::KILLED_VECTOR.' '
        .'with "(?P<weapon>'.CommonPatterns::WEAPON.')"(?P<headshot>.*)/';

    public string $type = 'Kill';

    public Carbon $timestamp;

    public PlayerIdentity $killer;

    public Vector3 $killerPos;

    public PlayerIdentity $killed;

    public Vector3 $killedPos;

    public string $weapon;

    public string $headshot;

    public function __construct(array $matches)
    {
        $killerString = $matches['killer'];
        $killedString = $matches['killed'];
        unset($matches['killer'], $matches['killed']);

        parent::__construct($matches);

        $this->killer = PlayerIdentity::fromString($killerString);
        $this->killed = PlayerIdentity::fromString($killedString);
        $this->killerPos = Vector3::fromMatches($matches, 'killer');
        $this->killedPos = Vector3::fromMatches($matches, 'killed');
    }
}
