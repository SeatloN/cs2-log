<?php

use CSLog\CS2\Models\ChangeMap;
use CSLog\CS2\Models\FreezePeriod;
use CSLog\CS2\Models\LogFileEvent;
use CSLog\CS2\Models\MatchEnd;
use CSLog\CS2\Models\MatchStatus;
use CSLog\CS2\Models\RconCommand;
use CSLog\CS2\Models\RoundDraw;
use CSLog\CS2\Models\RoundScored;
use CSLog\CS2\Models\SwitchTeam;
use CSLog\CS2\Models\TeamScored;
use CSLog\CS2\Models\WorldTriggered;
use CSLog\CS2\Patterns;
use CSLog\CS2\PlayerIdentity;

test('Timeout Terrorist', function () {
    $log = 'L 01/10/2024 - 20:42:01: rcon from "20.71.36.216:54356": command "timeout_terrorist_start"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RconCommand::class);
    expect($model->type)->toBe('RconCommand');
    expect($model->ip)->toBe('20.71.36.216:54356');
    expect($model->command)->toBe('timeout_terrorist_start');
    expect($model->commandName)->toBe('timeout_terrorist_start');
});

test('Timeout CT', function () {
    $log = 'L 01/10/2024 - 20:42:01: rcon from "20.71.36.216:54356": command "timeout_ct_start"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RconCommand::class);
    expect($model->type)->toBe('RconCommand');
    expect($model->ip)->toBe('20.71.36.216:54356');
    expect($model->command)->toBe('timeout_ct_start');
    expect($model->commandName)->toBe('timeout_ct_start');
});

test('Technical TimeOut', function () {
    $log = 'L 01/10/2024 - 20:42:01: rcon from "20.71.36.216:54356": command "mp_pause_match"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RconCommand::class);
    expect($model->type)->toBe('RconCommand');
    expect($model->ip)->toBe('20.71.36.216:54356');
    expect($model->command)->toBe('mp_pause_match');
    expect($model->commandName)->toBe('mp_pause_match');
});

test('Technical TimeOut Ended', function () {
    $log = 'L 01/10/2024 - 20:42:01: rcon from "20.71.36.216:54356": command "mp_unpause_match"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RconCommand::class);
    expect($model->type)->toBe('RconCommand');
    expect($model->ip)->toBe('20.71.36.216:54356');
    expect($model->command)->toBe('mp_unpause_match');
    expect($model->commandName)->toBe('mp_unpause_match');
});

test('Starting Freeze period', function () {
    $log = 'L 01/10/2024 - 20:52:46: Starting Freeze period';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(FreezePeriod::class);
    expect($model->type)->toBe('FreezePeriod');
});

test('Match Reloaded', function () {
    $log = 'L 01/19/2026 - 19:21:35: World triggered "Match_Reloaded" on "de_mirage"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(WorldTriggered::class);
    expect($model->type)->toBe('WorldTriggered');
    expect($model->event)->toBe('Match_Reloaded');
    expect($model->map)->toBe('de_mirage');
});

test('Round Draw', function () {
    $log = 'L 01/19/2026 - 19:21:35: World triggered "SFUI_Notice_Round_Draw" (CT "11") (T "0")';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RoundDraw::class);
    expect($model->type)->toBe('RoundDraw');
    expect($model->scoreA)->toBe(11);
    expect($model->scoreB)->toBe(0);
});

test('Backup File Loading', function () {
    $log = 'L 01/19/2026 - 19:21:35: rcon from "20.71.36.216:60696": command "mp_backup_restore_load_file cm_backup_cs2_match_de345abb-a155-4d1f-7839-08de566fc039_round11.txt"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RconCommand::class);
    expect($model->commandName)->toBe('mp_backup_restore_load_file');
    expect($model->ip)->toBe('20.71.36.216:60696');
    expect($model->argument)->toBe('cm_backup_cs2_match_de345abb-a155-4d1f-7839-08de566fc039_round11.txt');
});

test('Backup File Not triggering', function () {
    $log = 'L 01/19/2026 - 18:56:00: rcon from "20.71.36.216:61688": command "mp_backup_round_file_last"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RconCommand::class);
    expect($model->commandName)->toBe('mp_backup_round_file_last');

});

test('Log File Started', function () {
    $log = 'L 01/19/2026 - 18:55:38: Log file started (file "logs//0f870999-5f60-4259-7837-08de566fc039/2026_01_19_185538.log") (game "csgo") (version "10603")';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(LogFileEvent::class);
    expect($model->type)->toBe('LogFileEvent');
    expect($model->event)->toBe('started');
    expect($model->file)->toBe('logs//0f870999-5f60-4259-7837-08de566fc039/2026_01_19_185538.log');
    expect($model->game)->toBe('csgo');
    expect($model->version)->toBe('10603');
});

test('Rcon Command', function () {
    $log = 'L 01/19/2026 - 19:13:54: rcon from "20.71.36.216:60696": command "logaddress_add_http "https://publicapi.challengermode.com/CS2Logs?auth=M16iBkyoFvDAwnMUWqcZ92SnSd6dzjUVj-wRzmZs630&gameId=de345abb-a155-4d1f-7839-08de566fc039""';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RconCommand::class);
    expect($model->ip)->toBe('20.71.36.216:60696');
    expect($model->command)->toBe('logaddress_add_http "https://publicapi.challengermode.com/CS2Logs?auth=M16iBkyoFvDAwnMUWqcZ92SnSd6dzjUVj-wRzmZs630&gameId=de345abb-a155-4d1f-7839-08de566fc039"');
    expect($model->commandName)->toBe('logaddress_add_http');
    expect($model->argument)->toBe('"https://publicapi.challengermode.com/CS2Logs?auth=M16iBkyoFvDAwnMUWqcZ92SnSd6dzjUVj-wRzmZs630&gameId=de345abb-a155-4d1f-7839-08de566fc039"');
});

test('Warmup End', function () {
    $log = 'L 01/19/2026 - 19:15:32: World triggered "Warmup_End"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(WorldTriggered::class);
    expect($model->type)->toBe('WorldTriggered');
    expect($model->event)->toBe('Warmup_End');
});

test('Warmup Start', function () {
    $log = 'L 01/19/2026 - 19:15:32: World triggered "Warmup_Start"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(WorldTriggered::class);
    expect($model->type)->toBe('WorldTriggered');
    expect($model->event)->toBe('Warmup_Start');
});

test('Match Restart', function () {
    $log = 'L 01/19/2026 - 19:15:32: World triggered "Restart_Round_(4_seconds)"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(WorldTriggered::class);
    expect($model->type)->toBe('WorldTriggered');
    expect($model->event)->toBe('Restart_Round');
    expect($model->restartSeconds)->toBe(4);
});

test('MatchEnd', function () {
    $log = 'L 10/01/2023 - 17:18:40: Game Over: competitive mg_epic_bomb de_inferno score 15:15 after 42 min';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MatchEnd::class);
    expect($model->type)->toBe('MatchEnd');
    expect($model->mode)->toBe('competitive');
    expect($model->mapGroup)->toBe('mg_epic_bomb');
    expect($model->map)->toBe('de_inferno');
    expect($model->scoreA)->toBe(15);
    expect($model->scoreB)->toBe(15);
    expect($model->duration)->toBe(42);
});

test('MatchEnd - 2', function () {
    $log = 'L 01/19/2026 - 19:13:13: Game Over: competitive  de_inferno score 2:13 after 10 min';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MatchEnd::class);
    expect($model->type)->toBe('MatchEnd');
    expect($model->mode)->toBe('competitive');
    expect($model->mapGroup)->toBe('');
    expect($model->map)->toBe('de_inferno');
    expect($model->scoreA)->toBe(2);
    expect($model->scoreB)->toBe(13);
    expect($model->duration)->toBe(10);
});

test('MatchStart', function () {
    $log = 'L 10/01/2023 - 17:19:10: World triggered "Match_Start" on "de_inferno"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(WorldTriggered::class);
    expect($model->type)->toBe('WorldTriggered');
    expect($model->event)->toBe('Match_Start');
    expect($model->map)->toBe('de_inferno');
});

test('MatchStatus - 0:1', function () {
    $log = 'L 10/01/2023 - 16:38:24: MatchStatus: Score: 0:1 on map "de_inferno" RoundsPlayed: 1';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MatchStatus::class);
    expect($model->type)->toBe('MatchStatus');
    expect($model->scoreA)->toBe(0);
    expect($model->scoreB)->toBe(1);
    expect($model->map)->toBe('de_inferno');
    expect($model->roundsPlayed)->toBe(1);
});

test('MatchStatus - 2:13', function () {
    $log = 'L 10/01/2023 - 16:38:24: MatchStatus: Score: 2:13 on map "de_inferno" RoundsPlayed: 15';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MatchStatus::class);
    expect($model->type)->toBe('MatchStatus');
    expect($model->scoreA)->toBe(2);
    expect($model->scoreB)->toBe(13);
    expect($model->map)->toBe('de_inferno');
    expect($model->roundsPlayed)->toBe(15);
});



test('RoundEnd', function () {
    $log = 'L 10/01/2023 - 16:39:30: World triggered "Round_End"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(WorldTriggered::class);
    expect($model->type)->toBe('WorldTriggered');
    expect($model->event)->toBe('Round_End');
});

test('RoundRestart', function () {
    $log = 'L 06/29/2023 - 19:42:20: World triggered "Restart_Round_(1_second)"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(WorldTriggered::class);
    expect($model->type)->toBe('WorldTriggered');
    expect($model->restartSeconds)->toBe(1);
});

test('RoundScored', function () {
    $log = 'L 10/01/2023 - 16:39:30: Team "TERRORIST" triggered "SFUI_Notice_Terrorists_Win" (CT "0") (T "2")';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RoundScored::class);
    expect($model->type)->toBe('RoundScored');
    expect($model->team)->toBe('TERRORIST');
    expect($model->winType)->toBe(RoundScored::NORMAL);
});

test('RoundStart', function () {
    $log = 'L 10/01/2023 - 16:40:33: World triggered "Round_Start"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(WorldTriggered::class);
    expect($model->type)->toBe('WorldTriggered');
    expect($model->event)->toBe('Round_Start');
});

test('SwitchTeam', function () {
    $log = 'L 10/01/2023 - 16:54:57: "GEO<0><[U:1:353168853]>" switched from team <CT> to <TERRORIST>';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(SwitchTeam::class);
    expect($model->type)->toBe('SwitchTeam');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->player->name)->toBe('GEO');
    expect($model->player->steamId)->toBe('[U:1:353168853]');
    expect($model->player->team)->toBe('');
    expect($model->newTeam)->toBe('TERRORIST');
    expect($model->oldTeam)->toBe('CT');
});

test('TeamScored', function () {
    $log = 'L 10/01/2023 - 16:55:44: Team "TERRORIST" scored "8" with "5" players';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(TeamScored::class);
    expect($model->type)->toBe('TeamScored');

    expect($model->team)->toBe('TERRORIST');
    expect($model->score)->toBe(8);
    expect($model->players)->toBe(5);
});

test('ChangeMap', function () {
    $log = 'L 01/10/2024 - 20:22:50: Loading map "de_ancient"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(ChangeMap::class);
    expect($model->type)->toBe('ChangeMap');
    expect($model->maps)->toBe('de_ancient');
});