<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class FreezePeriod extends Model
{
    public const PATTERN = '/Starting Freeze period/';

    public string $type = 'FreezePeriod';
}
