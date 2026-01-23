<?php

namespace CS2\Models;

use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class Generic extends Model
{
    use ParsesTimestamp;

    // public const PATTERN = '/'.LogPrefix::UNIVERSAL.'/';
}
