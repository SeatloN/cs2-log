<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class Accolade extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'ACCOLADE, (?P<accolade_type>FINAL|MID): '
        .'\{(?P<category>[^}]+)\},\s+'
        .'(?P<player_name>[^<]+)<(?P<player_id>\d+)>,\s+'
        .'VALUE: (?P<value>-?\d+(?:\.\d+)?),\s+'
        .'POS: (?P<position>\d+),\s+'
        .'SCORE: (?P<score>-?\d+(?:\.\d+)?)/';

    public string $type = 'Accolade';

    public Carbon $timestamp;

    public string $accoladeType; // 'FINAL' or 'MID'

    public string $category; // e.g., 'pistolkills', 'cashspent', 'hsp', etc.

    public string $playerName;

    public int $playerId;

    public float $value;

    public int $position;

    public float $score;

    public function __construct(array $matches)
    {
        parent::__construct($matches);

        $this->accoladeType = $matches['accolade_type'];
        $this->category = $matches['category'];
        $this->playerName = $matches['player_name'];
        $this->playerId = (int) $matches['player_id'];
        $this->value = (float) $matches['value'];
        $this->position = (int) $matches['position'];
        $this->score = (float) $matches['score'];
    }

    public function isFinal(): bool
    {
        return $this->accoladeType === 'FINAL';
    }

    public function isMid(): bool
    {
        return $this->accoladeType === 'MID';
    }

    public function getCategoryName(): string
    {
        return match ($this->category) {
            'pistolkills' => 'Pistol Kills',
            'cashspent' => 'Cash Spent',
            'firstkills' => 'First Kills',
            'uniqueweaponkills' => 'Unique Weapon Kills',
            'burndamage' => 'Burn Damage',
            'hsp' => 'Headshot Percentage',
            'knifekills' => 'Knife Kills',
            'chickenskilled' => 'Chickens Killed',
            '4k' => '4K Rounds',
            default => ucfirst($this->category),
        };
    }
}
