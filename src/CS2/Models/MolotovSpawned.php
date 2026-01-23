<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class MolotovSpawned extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'Molotov projectile spawned at (?P<spawnPosX>[\-]?[0-9]+\.[0-9]+) (?P<spawnPosY>[\-]?[0-9]+\.[0-9]+) (?P<spawnPosZ>[\-]?[0-9]+\.[0-9]+), velocity (?P<velocityPosX>[\-]?[0-9]+\.[0-9]+) (?P<velocityPosY>[\-]?[0-9]+\.[0-9]+) (?P<velocityPosZ>[\-]?[0-9]+\.[0-9]+)/';

    public string $type = 'MolotovSpawned';

    public Carbon $timestamp;

    public float $spawnPosX;

    public float $spawnPosY;

    public float $spawnPosZ;

    public float $velocityPosX;

    public float $velocityPosY;

    public float $velocityPosZ;
}
