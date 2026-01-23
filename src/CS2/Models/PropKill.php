<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\CS2\ValueObjects\Vector3;
use CSLog\Model;

class PropKill extends Model
{
    use ParsesTimestamp;

    public const PATTERN =
        '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<killer>'.CommonPatterns::IDENTITY_INNER.') '
        .CommonPatterns::KILLER_VECTOR.' '
        .'killed other "(?P<propName>[a-zA-Z0-9_]+)<(?P<propId>\d+)>" '
        .CommonPatterns::PROP_VECTOR.' '
        .'with "(?P<weapon>[a-zA-Z0-9_]+)"(?: \((?P<flags>[^)]*)\))?$/';

    public string $type = 'PropKill';

    public Carbon $timestamp;

    public PlayerIdentity $killer;

    public Vector3 $killerPos;

    public string $propName;

    public int $propId;

    public Vector3 $propPos;

    public string $weapon;

    public ?string $flags = null;

    public function __construct(array $matches)
    {
        $killerString = $matches['killer'];
        $flagsString = $matches['flags'];
        unset($matches['killer'], $matches['flags']);

        parent::__construct($matches);

        $this->killer = PlayerIdentity::fromString($killerString);
        $this->killerPos = Vector3::fromMatches($matches, 'killer');
        $this->propPos = Vector3::fromMatches($matches, 'prop');

        // Only set items if the string is not empty
        if (isset($flagsString) && trim($flagsString) !== '') {
            $this->flags = trim($flagsString);
        }
    }
}
