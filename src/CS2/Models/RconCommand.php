<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class RconCommand extends Model
{
    public const PATTERN = '/rcon from "(?P<ip>[^"]+)": command "(?P<command>.+)"/';

    public string $type = 'RconCommand';

    public string $ip;

    public string $command;
}
