<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\DTO\MolotovThrowTraceDTO;
use CSLog\CS2\IdentityPattern;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class MolotovThrowTrace extends Model
{
    use ParsesTimestamp;

    public const PATTERN =
        '/'.LogPrefix::CLASSIC
        .'(?P<thrower>'.IdentityPattern::BLOCK_INNER.') '
        .'sv_throw_molotov '
        .'(?P<f1>-?\d+\.\d+) (?P<f2>-?\d+\.\d+) (?P<f3>-?\d+\.\d+) '
        .'(?P<f4>-?\d+\.\d+) (?P<f5>-?\d+\.\d+) (?P<f6>-?\d+\.\d+) '
        .'(?P<f7>-?\d+\.\d+) (?P<f8>-?\d+\.\d+) (?P<f9>-?\d+\.\d+) '
        .'(?P<f10>-?\d+\.\d+) (?P<f11>-?\d+\.\d+) (?P<f12>-?\d+\.\d+) '
        .'(?P<f13>-?\d+\.\d+)$/';

    public string $type = 'MolotovThrowTrace';

    public Carbon $timestamp;

    public MolotovThrowTraceDTO $dto;

    public PlayerIdentity $thrower;

    public function __construct(array $matches)
    {
        parent::__construct($matches);

        $this->thrower = PlayerIdentity::fromString($matches['thrower']);

        $this->dto = new MolotovThrowTraceDTO(
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
        );
    }
}
