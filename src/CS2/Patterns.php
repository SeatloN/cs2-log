<?php

namespace CSLog\CS2;

use CSLog\CS2\Models\Attack;
use CSLog\CS2\Models\BackupFileLoading;
use CSLog\CS2\Models\Blinded;
use CSLog\CS2\Models\BombDefusing;
use CSLog\CS2\Models\BombKill;
use CSLog\CS2\Models\BombPlanted;
use CSLog\CS2\Models\BombPlanting;
use CSLog\CS2\Models\ChangeMap;
use CSLog\CS2\Models\ChangeName;
use CSLog\CS2\Models\Connected;
use CSLog\CS2\Models\ConsoleSay;
use CSLog\CS2\Models\Disconnected;
use CSLog\CS2\Models\EnteredTheGame;
use CSLog\CS2\Models\FlashAssistedKill;
use CSLog\CS2\Models\FreezePeriod;
use CSLog\CS2\Models\GotTheBomb;
use CSLog\CS2\Models\JoinTeam;
use CSLog\CS2\Models\Kill;
use CSLog\CS2\Models\KillAssist;
use CSLog\CS2\Models\LeftBuyZone;
use CSLog\CS2\Models\LogFileStarted;
use CSLog\CS2\Models\MatchDraw;
use CSLog\CS2\Models\MatchEnd;
use CSLog\CS2\Models\MatchReloaded;
use CSLog\CS2\Models\MatchStart;
use CSLog\CS2\Models\MatchStatus;
use CSLog\CS2\Models\MolotovSpawned;
use CSLog\CS2\Models\MoneyChanged;
use CSLog\CS2\Models\PickedUp;
use CSLog\CS2\Models\Purchased;
use CSLog\CS2\Models\RconCommand;
use CSLog\CS2\Models\RoundEnd;
use CSLog\CS2\Models\RoundRestart;
use CSLog\CS2\Models\RoundScored;
use CSLog\CS2\Models\RoundStart;
use CSLog\CS2\Models\Say;
use CSLog\CS2\Models\SayTeam;
use CSLog\CS2\Models\SwitchTeam;
use CSLog\CS2\Models\TeamScored;
use CSLog\CS2\Models\Threw;
use CSLog\CS2\Models\TimeOut;
use CSLog\CS2\Models\WarmupEnd;
use CSLog\Model;

class Patterns
{
    protected array $patterns = [
        'Attack' => Attack::PATTERN,
        'Blinded' => Blinded::PATTERN,
        'BombDefusing' => BombDefusing::PATTERN,
        'BombPlanted' => BombPlanted::PATTERN,
        'BombPlanting' => BombPlanting::PATTERN,
        'BombKill' => BombKill::PATTERN,
        'ChangeMap' => ChangeMap::PATTERN,
        'ChangeName' => ChangeName::PATTERN,
        'ConsoleSay' => ConsoleSay::PATTERN,
        'Connected' => Connected::PATTERN,
        'Disconnected' => Disconnected::PATTERN,
        'EnteredTheGame' => EnteredTheGame::PATTERN,
        'GotTheBomb' => GotTheBomb::PATTERN,
        'JoinTeam' => JoinTeam::PATTERN,
        'Kill' => Kill::PATTERN,
        'KillAssist' => KillAssist::PATTERN,
        'LeftBuyZone' => LeftBuyZone::PATTERN,
        'MatchEnd' => MatchEnd::PATTERN,
        'MatchStart' => MatchStart::PATTERN,
        'MatchStatus' => MatchStatus::PATTERN,
        'MoneyChanged' => MoneyChanged::PATTERN,
        'PickedUp' => PickedUp::PATTERN,
        'Purchased' => Purchased::PATTERN,
        'RoundEnd' => RoundEnd::PATTERN,
        'RoundRestart' => RoundRestart::PATTERN,
        'RoundScored' => RoundScored::PATTERN,
        'RoundStart' => RoundStart::PATTERN,
        'Say' => Say::PATTERN,
        'SayTeam' => SayTeam::PATTERN,
        'SwitchTeam' => SwitchTeam::PATTERN,
        'TeamScored' => TeamScored::PATTERN,
        'Threw' => Threw::PATTERN,
        'FlashAssistedKill' => FlashAssistedKill::PATTERN,
        'TimeOut' => TimeOut::PATTERN,
        'MolotovSpawned' => MolotovSpawned::PATTERN,
        'FreezePeriod' => FreezePeriod::PATTERN,
        'MatchReloaded' => MatchReloaded::PATTERN,
        'MatchDraw' => MatchDraw::PATTERN,
        'BackupFileLoading' => BackupFileLoading::PATTERN,
        'LogFileStarted' => LogFileStarted::PATTERN,
        'RconCommand' => RconCommand::PATTERN,
        'WarmupEnd' => WarmupEnd::PATTERN,
    ];

    public static function match($log): ?Model
    {
        foreach (static::all() as $type => $regex) {
            $matches = [];
            if (preg_match($regex, $log, $matches)) {
                $class = 'CSLog\\CS2\\Models\\'.$type;

                if (class_exists($class)) {
                    return new $class($matches);
                }
            }
        }

        return null;
    }

    public static function all(): array
    {
        $obj = new self;

        return $obj->patterns;
    }

    public static function __callStatic($name, $arguments): ?string
    {
        $obj = new self;

        return $obj->patterns[$name] ?? null;
    }
}
