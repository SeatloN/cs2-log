<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class WarmupStart extends Model
{
    public const PATTERN = '/World triggered "Warmup_Start"/';

    public string $type = 'WarmupStart';
}
