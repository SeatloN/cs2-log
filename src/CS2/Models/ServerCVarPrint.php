<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\DTO\ServerCVarDTO;
use CSLog\CS2\Parsers\CVarValueParser;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class ServerCVarPrint extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_UNIVERSAL
        .'"(?P<cvar>[^"]+)"\s*=\s*"(?P<value>[^"]*)"$/';

    public string $type = 'ServerCVarPrint';

    public Carbon $timestamp;

    public ServerCVarDTO $dto;

    public function __construct(array $matches)
    {
        parent::__construct($matches);

        $this->dto = new ServerCVarDTO(
            timestamp: $matches['timestamp'],
            cvar: $matches['cvar'],
            value: CVarValueParser::parse($matches['value']),
            rawValue: $matches['value'],
        );
    }
}
