<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class MolotovSpawned extends Model
{
    public const PATTERN = '/Molotov projectile spawned at (?P<spawnPosX>[\-]?[0-9]+\.[0-9]+) (?P<spawnPosY>[\-]?[0-9]+\.[0-9]+) (?P<spawnPosZ>[\-]?[0-9]+\.[0-9]+), velocity (?P<velocityPosX>[\-]?[0-9]+\.[0-9]+) (?P<velocityPosY>[\-]?[0-9]+\.[0-9]+) (?P<velocityPosZ>[\-]?[0-9]+\.[0-9]+)/';

    public string $type = 'MolotovSpawned';

    public float $spawnPosX;

    public float $spawnPosY;

    public float $spawnPosZ;

    public float $velocityPosX;

    public float $velocityPosY;

    public float $velocityPosZ;
}
