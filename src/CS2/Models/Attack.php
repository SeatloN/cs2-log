<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\CS2\ValueObjects\Vector3;
use CSLog\Model;

class Attack extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<attacker>'.CommonPatterns::IDENTITY_INNER.') '
        .CommonPatterns::ATTACKER_VECTOR.' '
        .'attacked '
        .'(?P<victim>'.CommonPatterns::IDENTITY_INNER.') '
        .CommonPatterns::VICTIM_VECTOR.' '
        .'with "(?P<attackerWeapon>[a-zA-Z0-9_]*)" '
        .'\(damage "(?P<attackerDamage>[0-9]+)"\) '
        .'\(damage_armor "(?P<attackerDamageArmor>[0-9]+)"\) '
        .'\(health "(?P<victimHealth>[0-9]+)"\) '
        .'\(armor "(?P<victimArmor>[0-9]+)"\) '
        .'\(hitgroup "(?P<victimHitGroup>[^"]+)"\)/';

    public string $type = 'Attack';

    public Carbon $timestamp;

    public PlayerIdentity $attacker;

    public Vector3 $attackerPos;

    public string $attackerWeapon;

    public int $attackerDamage;

    public int $attackerDamageArmor;

    public PlayerIdentity $victim;

    public Vector3 $victimPos;

    public int $victimHealth;

    public int $victimArmor;

    public string $victimHitGroup;

    public function __construct(array $matches)
    {
        $attackerString = $matches['attacker'];
        $victimString = $matches['victim'];
        unset($matches['attacker'], $matches['victim']);

        parent::__construct($matches);

        $this->attacker = PlayerIdentity::fromString($attackerString);
        $this->victim = PlayerIdentity::fromString($victimString);
        $this->attackerPos = Vector3::fromMatches($matches, 'attacker');
        $this->victimPos = Vector3::fromMatches($matches, 'victim');
    }
}
