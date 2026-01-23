<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\DTO\ServerCVarDTO;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Parsers\CVarValueParser;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class ServerCVar extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::UNIVERSAL.'server_cvar: "(?P<cvar>[^"]+)" "(?P<value>[^"]*)"$/';

    public string $type = 'ServerCVar';

    public Carbon $timestamp;

    public ServerCVarDTO $dto;

    public string $cvar;

    public string $value;

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
