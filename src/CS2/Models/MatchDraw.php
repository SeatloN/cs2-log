<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class MatchDraw extends Model
{
    public const PATTERN = '/World triggered "SFUI_Notice_Round_Draw" \(CT "(?P<scoreA>[0-9]{1,2})"\) \(T "(?P<scoreB>[0-9]{1,2})"\)/';

    public string $type = 'MatchDraw';

    public int $scoreA;

    public int $scoreB;

}
