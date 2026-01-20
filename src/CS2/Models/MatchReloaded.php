<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class MatchReloaded extends Model
{
    public const PATTERN = '/World triggered "Match_Reloaded" on "(?P<map>[a-z_0-9]*+)"/';

    public string $type = 'MatchReloaded';

    public string $map;
}