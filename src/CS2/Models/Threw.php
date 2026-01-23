<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class Threw extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<thrower>'.CommonPatterns::IDENTITY_INNER.') '
        .'threw (?P<item>hegrenade|flashbang|smokegrenade|decoy|molotov) '
        .'\[(?P<posX>[\-]?[0-9]+) (?P<posY>[\-]?[0-9]+) (?P<posZ>[\-]?[0-9]+)\](?: flashbang entindex (?P<entindex>[0-9]+))?/';

    public string $type = 'Threw';

    public Carbon $timestamp;

    public PlayerIdentity $thrower;

    public int $posX;

    public int $posY;

    public int $posZ;

    public string $item;

    public ?int $entindex = null;

    public function __construct(array $matches)
    {
        $throwerString = $matches['thrower'];
        unset($matches['thrower']);

        parent::__construct($matches);

        $this->thrower = PlayerIdentity::fromString($throwerString);
    }
}
