<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class Blinded extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<victim>'.CommonPatterns::IDENTITY_INNER.') '
        .'blinded for (?<time>[0-9.]+) by '
        .'(?P<thrower>'.CommonPatterns::IDENTITY_INNER.') '
        .'from flashbang entindex (?<entindex>[0-9]+)/';

    public string $type = 'Blinded';

    public Carbon $timestamp;

    public PlayerIdentity $victim;

    public PlayerIdentity $thrower;

    public float $time;

    public int $entindex;

    public function __construct(array $matches)
    {
        $throwerString = $matches['thrower'];
        $victimString = $matches['victim'];
        unset($matches['thrower'], $matches['victim']);

        parent::__construct($matches);

        $this->thrower = PlayerIdentity::fromString($throwerString);
        $this->victim = PlayerIdentity::fromString($victimString);
    }
}
