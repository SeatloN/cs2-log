<?php

namespace CSLog\CS2;

class CommonPatterns
{
    /**
     * Log prefix patterns.
     */
    public const PREFIX_UNIVERSAL = '^(?:L )?(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}(?:\.\d{3})?)\s*(?::| - )\s+';

    /**
     * Classic log prefix pattern.
     */
    public const PREFIX_CLASSIC =
        '^(?:L )?(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}(?:\.\d{3})?):\s+';

    /**
     * New log prefix pattern.
     */
    public const PREFIX_NEW =
        '^(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}\.\d{3}) -\s+';

    /**
     * Identity block: "name<id><steam><team>"
     */
    public const IDENTITY =
        '"(?P<name>.+?)<(?P<id>\d+)><(?P<steam>[^>]*)>(?:<(?P<team>[^>]*)>)?"';

    /**
     * Identity block without named groups.
     */
    public const IDENTITY_INNER =
        '"(.+?)<\d+><[^>]*>(?:<[^>]*>)?"';

    /**
     * 3D coordinate vector: [x y z]
     */
    public const VECTOR_3D =
        '\[(?P<x>-?\d+) (?P<y>-?\d+) (?P<z>-?\d+)\]';

    /**
     * Same vector without named groups.
     */
    public const VECTOR_3D_INNER =
        '\[-?\d+ -?\d+ -?\d+\]';

    public const KILLER_VECTOR =
        '\[(?P<killerX>-?\d+) (?P<killerY>-?\d+) (?P<killerZ>-?\d+)\]';

    public const KILLED_VECTOR =
        '\[(?P<killedX>-?\d+) (?P<killedY>-?\d+) (?P<killedZ>-?\d+)\]';

    public const ATTACKER_VECTOR =
        '\[(?P<attackerX>-?\d+) (?P<attackerY>-?\d+) (?P<attackerZ>-?\d+)\]';

    public const VICTIM_VECTOR =
        '\[(?P<victimX>-?\d+) (?P<victimY>-?\d+) (?P<victimZ>-?\d+)\]';

    public const PLAYER_VECTOR =
        '\[(?P<playerX>-?\d+) (?P<playerY>-?\d+) (?P<playerZ>-?\d+)\]';

    public const PROP_VECTOR =
        '\[(?P<propX>-?\d+) (?P<propY>-?\d+) (?P<propZ>-?\d+)\]';

    public const OBJECT_VECTOR =
        '\[(?P<objectX>-?\d+) (?P<objectY>-?\d+) (?P<objectZ>-?\d+)\]';

    public const TARGET_VECTOR =
        '\[(?P<targetX>-?\d+) (?P<targetY>-?\d+) (?P<targetZ>-?\d+)\]';

    public const ORIGIN_VECTOR =
        '\[(?P<originX>-?\d+) (?P<originY>-?\d+) (?P<originZ>-?\d+)\]';

    public const SPAWN_VECTOR =
        '\[(?P<spawnX>-?\d+) (?P<spawnY>-?\d+) (?P<spawnZ>-?\d+)\]';

    /**
     * Team names.
     */
    public const TEAM =
        '(CT|TERRORIST|Unassigned|Spectator|)';

    /**
     * SteamID (Steam3 format).
     */
    public const STEAM_ID =
        '\[U:\d:\d+\]';

    /**
     * Weapon names (generic).
     */
    public const WEAPON =
        '[A-Za-z0-9_]+';

    /**
     * Boolean flags inside parentheses.
     */
    public const FLAGS =
        '(?:\s*\((?P<flags>[^)]*)\))?$';

    public static function vector3(string $prefix): string
    {
        return '\[(?P<'.$prefix.'X>-?\d+) (?P<'.$prefix.'Y>-?\d+) (?P<'.$prefix.'Z>-?\d+)\]';
    }

    public static function parseFlags(?string $raw): array
    {
        if ($raw === null) {
            return [];
        }

        $trimmed = trim($raw);

        if ($trimmed === '') {
            return [];
        }

        return preg_split('/\s+/', $trimmed);
    }
}
