<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class WarmupEnd extends Model
{
    public const PATTERN = '/World triggered "Warmup_End"/';

    public string $type = 'WarmupEnd';
}
