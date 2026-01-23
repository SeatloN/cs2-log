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
use CSLog\CS2\Models\MatchEnd;
use CSLog\CS2\Models\MatchStatus;
use CSLog\CS2\Models\MolotovSpawned;
use CSLog\CS2\Models\MolotovThrowTrace;
use CSLog\CS2\Models\MoneyChanged;
use CSLog\CS2\Models\PickedUp;
use CSLog\CS2\Models\PropKill;
use CSLog\CS2\Models\Purchased;
use CSLog\CS2\Models\RconCommand;
use CSLog\CS2\Models\RoundDraw;
use CSLog\CS2\Models\RoundRestart;
use CSLog\CS2\Models\RoundScored;
use CSLog\CS2\Models\Say;
use CSLog\CS2\Models\SayTeam;
use CSLog\CS2\Models\ServerCVar;
use CSLog\CS2\Models\ServerCVarBlock;
use CSLog\CS2\Models\ServerCVarPrint;
use CSLog\CS2\Models\Started;
use CSLog\CS2\Models\SteamIdValidated;
use CSLog\CS2\Models\Suicide;
use CSLog\CS2\Models\SwitchTeam;
use CSLog\CS2\Models\TeamPlaying;
use CSLog\CS2\Models\TeamScored;
use CSLog\CS2\Models\Threw;
use CSLog\CS2\Models\TimeOut;
use CSLog\CS2\Models\WorldTriggered;
use CSLog\Model;

class Patterns
{
    // Need to be ordered from most specific to least specific
    protected array $patterns = [
        'Attack' => Attack::PATTERN,
        'Kill' => Kill::PATTERN,
        'BombDefusing' => BombDefusing::PATTERN,
        'Blinded' => Blinded::PATTERN,
        'BombPlanted' => BombPlanted::PATTERN,
        'BombPlanting' => BombPlanting::PATTERN,
        'BombKill' => BombKill::PATTERN,
        'ChangeMap' => ChangeMap::PATTERN,
        'ChangeName' => ChangeName::PATTERN,
        'Connected' => Connected::PATTERN,
        'Disconnected' => Disconnected::PATTERN,
        'EnteredTheGame' => EnteredTheGame::PATTERN,
        'GotTheBomb' => GotTheBomb::PATTERN,
        'JoinTeam' => JoinTeam::PATTERN,
        'KillAssist' => KillAssist::PATTERN,
        'LeftBuyZone' => LeftBuyZone::PATTERN,
        'MatchEnd' => MatchEnd::PATTERN,
        'MatchStatus' => MatchStatus::PATTERN,
        'MoneyChanged' => MoneyChanged::PATTERN,
        'PickedUp' => PickedUp::PATTERN,
        'Purchased' => Purchased::PATTERN,
        'RoundRestart' => RoundRestart::PATTERN,
        'RoundScored' => RoundScored::PATTERN,
        'Say' => Say::PATTERN,
        'SayTeam' => SayTeam::PATTERN,
        'SwitchTeam' => SwitchTeam::PATTERN,
        'TeamScored' => TeamScored::PATTERN,
        'Threw' => Threw::PATTERN,
        'FlashAssistedKill' => FlashAssistedKill::PATTERN,
        'TimeOut' => TimeOut::PATTERN,
        'MolotovSpawned' => MolotovSpawned::PATTERN,
        'FreezePeriod' => FreezePeriod::PATTERN,
        'RoundDraw' => RoundDraw::PATTERN,
        'WorldTriggered' => WorldTriggered::PATTERN,
        'ServerCVar' => ServerCVar::PATTERN,
        'ServerCVarBlock' => ServerCVarBlock::PATTERN,
        'ServerCVarPrint' => ServerCVarPrint::PATTERN,
        'BackupFileLoading' => BackupFileLoading::PATTERN,
        'TeamPlaying' => TeamPlaying::PATTERN,
        'RconCommand' => RconCommand::PATTERN,
        'LogFileStarted' => LogFileStarted::PATTERN,
        'Started' => Started::PATTERN,
        'SteamIdValidated' => SteamIdValidated::PATTERN,
        'Suicide' => Suicide::PATTERN,
        'PropKill' => PropKill::PATTERN,
        'MolotovThrowTrace' => MolotovThrowTrace::PATTERN,
    ];

    public static function match($log): ?Model
    {
        foreach (static::all() as $type => $regex) {
            // echo "Checking $type\n";
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

    public static function generateSampleLine(string $regex): ?string
    {
        // Try to extract a quoted literal from the regex
        if (preg_match('/"([^"]+)"/', $regex, $m)) {
            return 'L 01/01/2026 - 00:00:00: '.$m[0];
        }

        // Try to extract a word literal
        if (preg_match('/\b([A-Za-z_]+)\b/', $regex, $m)) {
            return 'L 01/01/2026 - 00:00:00: '.$m[1];
        }

        return null;
    }

    public static function scoreRegex(string $regex): int
    {
        $score = 0;

        // Reward literal quoted strings
        preg_match_all('/"([^"]+)"/', $regex, $quoted);
        foreach ($quoted[1] as $literal) {
            $score += strlen($literal) * 5;
        }

        // Reward literal words
        preg_match_all('/\b([A-Za-z_]{3,})\b/', $regex, $words);
        foreach ($words[1] as $word) {
            $score += strlen($word);
        }

        // Penalize wildcards
        $score -= preg_match_all('/\.\*/', $regex) * 10;
        $score -= preg_match_all('/\.\+/', $regex) * 8;
        $score -= preg_match_all('/\s\+/', $regex) * 5;

        // Penalize optional groups
        $score -= preg_match_all('/\(\?:.*\?\)/U', $regex) * 6;
        $score -= preg_match_all('/\(.+?\?\)/U', $regex) * 6;

        return max($score, 0);
    }

    public static function rankedBySpecificity(): array
    {
        $patterns = static::all();
        $ranked = [];

        foreach ($patterns as $type => $regex) {
            $ranked[$type] = static::scoreRegex($regex);
        }

        arsort($ranked);

        return $ranked;
    }

    public static function autoReorder(): array
    {
        $patterns = static::all();
        $scored = [];

        foreach ($patterns as $type => $regex) {
            $scored[$type] = static::scoreRegex($regex);
        }

        // Sort by descending specificity
        arsort($scored);

        $reordered = [];
        foreach ($scored as $type => $score) {
            $reordered[$type] = $patterns[$type];
        }

        return $reordered;
    }
}
