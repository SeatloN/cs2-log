<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Dto\GrenadeThrowTraceDTO;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class GrenadeThrowTrace extends Model
{
    use ParsesTimestamp;

    public const PATTERN =
        '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<thrower>'.CommonPatterns::IDENTITY_INNER.') '
        .'sv_throw_(?P<grenade_type>molotov|hegrenade|flashgrenade|smokegrenade|decoygrenade) '
        .'(?P<f1>-?\d+\.\d+) (?P<f2>-?\d+\.\d+) (?P<f3>-?\d+\.\d+) '
        .'(?P<f4>-?\d+\.\d+) (?P<f5>-?\d+\.\d+) (?P<f6>-?\d+\.\d+) '
        .'(?P<f7>-?\d+\.\d+) (?P<f8>-?\d+\.\d+) (?P<f9>-?\d+\.\d+) '
        .'(?P<f10>-?\d+\.\d+) (?P<f11>-?\d+\.\d+) (?P<f12>-?\d+\.\d+) '
        .'(?P<f13>-?\d+(?:\.\d+)?)'
        .'(?: (?P<f14>-?\d+(?:\.\d+)?))?/'; // f14 is optional (only for HE grenades)

    public string $type = 'GrenadeThrowTrace';

    public Carbon $timestamp;

    public GrenadeThrowTraceDTO $dto;

    public PlayerIdentity $thrower;

    public string $grenadeType; // 'molotov', 'hegrenade', 'flashgrenade', 'smokegrenade', 'decoygrenade'

    public function __construct(array $matches)
    {
        $throwerString = $matches['thrower'];
        $grenadeType = $matches['grenade_type'];
        unset($matches['thrower'], $matches['grenade_type']);

        parent::__construct($matches);

        $this->thrower = PlayerIdentity::fromString($throwerString);
        $this->grenadeType = $grenadeType;

        $this->dto = new GrenadeThrowTraceDTO(
            grenadeType: $grenadeType,
            origin: [
                (float) $matches['f1'],
                (float) $matches['f2'],
                (float) $matches['f3'],
            ],
            angles: [
                (float) $matches['f4'],
                (float) $matches['f5'],
                (float) $matches['f6'],
            ],
            velocity: [
                (float) $matches['f7'],
                (float) $matches['f8'],
                (float) $matches['f9'],
            ],
            angularVelocity: [
                (float) $matches['f10'],
                (float) $matches['f11'],
                (float) $matches['f12'],
            ],
            tickOrFuse: (int) $matches['f13'],
            fuseTime: isset($matches['f14']) && $matches['f14'] !== ''
                ? (float) $matches['f14']
                : null,
        );
    }

    public function isMolotov(): bool
    {
        return $this->grenadeType === 'molotov';
    }

    public function isHEGrenade(): bool
    {
        return $this->grenadeType === 'hegrenade';
    }

    public function isFlashbang(): bool
    {
        return $this->grenadeType === 'flashgrenade';
    }

    public function isSmoke(): bool
    {
        return $this->grenadeType === 'smokegrenade';
    }

    public function isDecoy(): bool
    {
        return $this->grenadeType === 'decoygrenade';
    }
}
