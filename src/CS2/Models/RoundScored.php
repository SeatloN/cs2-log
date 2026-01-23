<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class RoundScored extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'Team "(?P<team>.*)" triggered "SFUI_Notice_(?P<teamWin>Terrorists_Win|CTs_Win|Target_Bombed|Target_Saved|Bomb_Defused)/';

    public const TARGET_BOMBED = 'target_bombed';

    public const NORMAL = 'normal';

    public const SAVED = 'saved';

    public const BOMB_DEFUSED = 'bomb_defused';

    public string $type = 'RoundScored';

    public Carbon $timestamp;

    public string $teamWin;

    public string $team;

    public string $winType;

    public function __construct($data = [])
    {
        parent::__construct($data);

        switch ($this->teamWin) {
            case 'Target_Bombed':
                $this->winType = self::TARGET_BOMBED;
                $this->teamWin = 'TERRORIST';
                break;
            case 'Terrorists_Win':
                $this->winType = self::NORMAL;
                $this->teamWin = 'TERRORIST';
                break;
            case 'Target_Saved':
                $this->winType = self::SAVED;
                $this->teamWin = 'CT';
                break;
            case 'Bomb_Defused':
                $this->winType = self::BOMB_DEFUSED;
                $this->teamWin = 'CT';
            case 'CTs_Win':
                $this->winType = self::NORMAL;
                $this->teamWin = 'CT';
                break;
        }
    }
}
