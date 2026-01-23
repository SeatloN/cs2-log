<?php

use CSLog\CS2\Models\Attack;
use CSLog\CS2\Models\Blinded;
use CSLog\CS2\Models\BombDefusing;
use CSLog\CS2\Models\BombEvent;
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
use CSLog\CS2\Models\Kill;
use CSLog\CS2\Models\KillAssist;
use CSLog\CS2\Models\LeftBuyZone;
use CSLog\CS2\Models\LogFileEvent;
use CSLog\CS2\Models\MatchEnd;
use CSLog\CS2\Models\MatchStatus;
use CSLog\CS2\Models\MolotovSpawned;
use CSLog\CS2\Models\MoneyChanged;
use CSLog\CS2\Models\PickedUp;
use CSLog\CS2\Models\Purchased;
use CSLog\CS2\Models\RconCommand;
use CSLog\CS2\Models\RoundDraw;
use CSLog\CS2\Models\RoundScored;
use CSLog\CS2\Models\Say;
use CSLog\CS2\Models\SwitchTeam;
use CSLog\CS2\Models\TeamScored;
use CSLog\CS2\Models\Threw;
use CSLog\CS2\Models\WorldTriggered;
use CSLog\CS2\Patterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\ValueObjects\Vector3;

test('Attack', function () {
    $log = 'L 10/01/2023 - 16:31:58: "GEO<0><[U:1:353168853]><CT>" [-884 537 -32] attacked "Elix<3><[U:1:302549372]><TERRORIST>" [-1035 564 -47] with "m4a1" (damage "90") (damage_armor "19") (health "10") (armor "81") (hitgroup "head")';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Attack::class);
    expect($model->type)->toBe('Attack');
    expect($model->attacker)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->attackerPos)->toBeInstanceOf(Vector3::class);
    expect($model->attackerWeapon)->toBe('m4a1');
    expect($model->attackerDamage)->toBe(90);
    expect($model->attackerDamageArmor)->toBe(19);
    expect($model->victimHitGroup)->toBe('head');
    expect($model->victim)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->victimPos)->toBeInstanceOf(Vector3::class);
    expect($model->victimHealth)->toBe(10);
    expect($model->victimArmor)->toBe(81);
});

test('Blinded', function () {
    $log = 'L 10/01/2023 - 16:58:41: "Kaph<6><[U:1:149882025]><CT>" blinded for 1.01 by "Scriib<8><[U:1:94156635]><CT>" from flashbang entindex 568';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Blinded::class);
    expect($model->type)->toBe('Blinded');
    expect($model->thrower)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->time)->toBe(1.01);
    expect($model->victim)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->entindex)->toBe(568);
});

test('BombDefusing', function () {
    $log = 'L 10/01/2023 - 16:49:35: "index<4><[U:1:98202654]><CT>" triggered "Begin_Bomb_Defuse_Without_Kit"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombDefusing::class);
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
});

test('BombPlanting', function () {
    $log = 'L 10/01/2023 - 16:53:03: "Kaph<6><[U:1:149882025]><TERRORIST>" triggered "Bomb_Begin_Plant" at bombsite B';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombPlanting::class);
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->bombsite)->toBe('B');
});

test('ChangeMap', function () {
    $log = 'L 01/10/2024 - 20:22:50: Loading map "de_ancient"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(ChangeMap::class);
    expect($model->type)->toBe('ChangeMap');
    expect($model->maps)->toBe('de_ancient');
});

test('ChangeName', function () {
    $log = 'L 06/29/2023 - 19:36:46: "majky<4><STEAM_1:0:436676464><Unassigned>" changed name to "majkycs"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(ChangeName::class);
    expect($model->type)->toBe('ChangeName');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->newName)->toBe('majkycs');
});

test('Connected', function () {
    $log = 'L 10/01/2023 - 16:32:46: "Scriib<8><[U:1:94156635]><>" connected, address "127.0.0.1:1234"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Connected::class);
    expect($model->type)->toBe('Connected');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->address)->toBe('127.0.0.1:1234');
});

test('Disconnected', function () {
    $log = 'L 10/01/2023 - 17:18:54: "Elix<3><[U:1:302549372]><TERRORIST>" disconnected (reason "NETWORK_DISCONNECT_DISCONNECT_BY_USER")';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Disconnected::class);
    expect($model->type)->toBe('Disconnected');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->reason)->toBe('NETWORK_DISCONNECT_DISCONNECT_BY_USER');
});

test('EnteredTheGame', function () {
    $log = 'L 10/01/2023 - 16:31:24: "GEO<0><[U:1:353168853]><>" entered the game';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(EnteredTheGame::class);
    expect($model->type)->toBe('EnteredTheGame');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
});

test('GotTheBomb', function () {
    $log = 'L 10/01/2023 - 16:37:01: "Scriib<8><[U:1:94156635]><TERRORIST>" triggered "Got_The_Bomb"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombEvent::class);
    expect($model->type)->toBe('BombEvent');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->event)->toBe('Got_The_Bomb');
});

test('Kill', function () {
    $log = 'L 10/01/2023 - 16:32:00: "GEO<0><[U:1:353168853]><CT>" [-835 525 -32] killed "Elix<3><[U:1:302549372]><TERRORIST>" [-762 615 -30] with "m4a1_silencer"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Kill::class);
    expect($model->type)->toBe('Kill');
    expect($model->killer)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killerPos)->toBeInstanceOf(Vector3::class);

    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killedPos)->toBeInstanceOf(Vector3::class);

    expect($model->weapon)->toBe('m4a1_silencer');
    expect($model->headshot)->toBe('');
});

test('KillHeadshot', function () {
    $log = 'L 10/01/2023 - 16:32:00: "GEO<0><[U:1:353168853]><CT>" [-835 525 -32] killed "Elix<3><[U:1:302549372]><TERRORIST>" [-762 615 -30] with "m4a1_silencer" (headshot)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Kill::class);
    expect($model->type)->toBe('Kill');
    expect($model->killer)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killerPos)->toBeInstanceOf(Vector3::class);
    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killedPos)->toBeInstanceOf(Vector3::class);
    expect($model->weapon)->toBe('m4a1_silencer');
    expect($model->headshot)->toBe(' (headshot)');
});

test('KillThroughSmoke', function () {
    $log = 'L 10/01/2023 - 16:32:00: "GEO<0><[U:1:353168853]><CT>" [-835 525 -32] killed "Elix<3><[U:1:302549372]><TERRORIST>" [-762 615 -30] with "m4a1_silencer" (throughsmoke)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Kill::class);
    expect($model->type)->toBe('Kill');
    expect($model->killer)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killerPos)->toBeInstanceOf(Vector3::class);
    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killedPos)->toBeInstanceOf(Vector3::class);
    expect($model->weapon)->toBe('m4a1_silencer');
    expect($model->headshot)->toBe(' (throughsmoke)');
});

test('KillThroughWall', function () {
    $log = 'L 10/01/2023 - 16:32:00: "GEO<0><[U:1:353168853]><CT>" [-835 525 -32] killed "Elix<3><[U:1:302549372]><TERRORIST>" [-762 615 -30] with "m4a1_silencer" (penetrated)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Kill::class);
    expect($model->type)->toBe('Kill');
    expect($model->killer)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killerPos)->toBeInstanceOf(Vector3::class);
    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killedPos)->toBeInstanceOf(Vector3::class);
    expect($model->weapon)->toBe('m4a1_silencer');
    expect($model->headshot)->toBe(' (penetrated)');
});

test('BombKill', function () {
    $log = 'L 01/10/2024 - 20:38:47: "sjuush<7><[U:1:200443857]><CT>" [-586 -856 85] was killed by the bomb.';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombKill::class);
    expect($model->type)->toBe('BombKill');
    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killedPos)->toBeInstanceOf(Vector3::class);
});

test('KillAssist', function () {
    $log = 'L 10/01/2023 - 16:32:16: "Elix<3><[U:1:302549372]><TERRORIST>" assisted killing "GEO<0><[U:1:353168853]><CT>"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(KillAssist::class);
    expect($model->type)->toBe('KillAssist');
    expect($model->assister)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->assister->name)->toBe('Elix');
    expect($model->assister->steam)->toBe('[U:1:302549372]');
    expect($model->assister->team)->toBe('TERRORIST');
    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killed->name)->toBe('GEO');
    expect($model->killed->steam)->toBe('[U:1:353168853]');
    expect($model->killed->team)->toBe('CT');
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

test('MatchStatus', function () {
    $log = 'L 10/01/2023 - 16:38:24: MatchStatus: Score: 0:1 on map "de_inferno" RoundsPlayed: 1';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MatchStatus::class);
    expect($model->type)->toBe('MatchStatus');
    expect($model->scoreA)->toBe(0);
    expect($model->scoreB)->toBe(1);
    expect($model->map)->toBe('de_inferno');
    expect($model->roundsPlayed)->toBe(1);
});

test('Purchased', function () {
    $log = 'L 10/01/2023 - 16:38:28: "Elix<3><[U:1:302549372]><TERRORIST>" purchased "sawedoff"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Purchased::class);
    expect($model->type)->toBe('Purchased');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->object)->toBe('sawedoff');
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

test('Say', function () {
    $log = 'L 06/29/2023 - 19:58:01: "boro494<5><STEAM_1:0:52867709><TERRORIST>" say "kto hraje wipo bajo? saltovsky?"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Say::class);
    expect($model->type)->toBe('Say');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->player->name)->toBe('boro494');
    expect($model->player->steam)->toBe('STEAM_1:0:52867709');
    expect($model->text)->toBe('kto hraje wipo bajo? saltovsky?');
});

test('SwitchTeam', function () {
    $log = 'L 10/01/2023 - 16:54:57: "GEO<0><[U:1:353168853]>" switched from team <CT> to <TERRORIST>';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(SwitchTeam::class);
    expect($model->type)->toBe('SwitchTeam');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->player->name)->toBe('GEO');
    expect($model->player->steam)->toBe('[U:1:353168853]');
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

test('Threw - flash', function () {
    $log = 'L 10/01/2023 - 16:56:14: "index<4><[U:1:98202654]><TERRORIST>" threw flashbang [1172 435 158] flashbang entindex 930)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Threw::class);
    expect($model->type)->toBe('Threw');

    expect($model->thrower)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->thrower->name)->toBe('index');
    expect($model->thrower->steam)->toBe('[U:1:98202654]');
    expect($model->thrower->team)->toBe('TERRORIST');
    expect($model->item)->toBe('flashbang');
    expect($model->entindex)->toBe(930);
    expect($model->posX)->toBe(1172);
    expect($model->posY)->toBe(435);
    expect($model->posZ)->toBe(158);
});

test('Threw - smoke', function () {
    $log = 'L 10/01/2023 - 16:58:37: "Scriib<8><[U:1:94156635]><CT>" threw smokegrenade [735 2440 138]';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Threw::class);
    expect($model->type)->toBe('Threw');

    expect($model->thrower)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->thrower->name)->toBe('Scriib');
    expect($model->thrower->steam)->toBe('[U:1:94156635]');
    expect($model->thrower->team)->toBe('CT');
    expect($model->item)->toBe('smokegrenade');
    expect($model->entindex)->toBeNull();
    expect($model->posX)->toBe(735);
    expect($model->posY)->toBe(2440);
    expect($model->posZ)->toBe(138);
});

test('Picked Up', function () {
    $log = 'L 10/01/2023 - 16:58:37: "SeatloN<2><[U:1:6318168]><TERRORIST>" picked up "molotov"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(PickedUp::class);
    expect($model->type)->toBe('PickedUp');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->player->name)->toBe('SeatloN');
    expect($model->player->steam)->toBe('[U:1:6318168]');
    expect($model->player->team)->toBe('TERRORIST');
    expect($model->object)->toBe('molotov');
});

test('Money Changed', function () {
    $log = 'L 01/19/2026 - 18:56:05: "SeatloN<3><[U:1:6318168]><TERRORIST>" money change 5500-400 = $5100 (tracked) (purchase: weapon_molotov)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MoneyChanged::class);
    expect($model->type)->toBe('MoneyChanged');

    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->before)->toBe(5500);
    expect($model->operation)->toBe('-');
    expect($model->amount)->toBe(400);
    expect($model->bank)->toBe(5100);
    expect($model->actionType)->toBe('purchase');
    expect($model->actionDetail)->toBe('weapon_molotov');
});

test('Bomb Planted', function () {
    $log = 'L 01/10/2024 - 20:38:06: "FinigaN<6><[U:1:226095351]><TERRORIST>" triggered "Planted_The_Bomb" at bombsite B';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombPlanted::class);
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->bombsite)->toBe('B');
});

test('Left Buyzone', function () {
    $log = 'L 01/10/2024 - 21:02:00: "nicoodoz<8><[U:1:112851399]><TERRORIST>" left buyzone with [ weapon_knife_butterfly weapon_glock weapon_ak47 weapon_molotov weapon_hegrenade weapon_smokegrenade kevlar(100) helmet ]';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(LeftBuyZone::class);
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->items)->toBe('weapon_knife_butterfly weapon_glock weapon_ak47 weapon_molotov weapon_hegrenade weapon_smokegrenade kevlar(100) helmet');
});

test('Left Buyzone - Without anything.', function () {
    $log = 'L 01/10/2024 - 21:02:00: "nicoodoz<8><[U:1:112851399]><TERRORIST>" left buyzone with [ ]';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(LeftBuyZone::class);
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->items)->toBeNull();
});

test('Flash Assisted Kill', function () {
    $log = 'L 01/10/2024 - 20:39:24: "znxjez<5><[U:1:23528558]><TERRORIST>" flash-assisted killing "sjuush<7><[U:1:200443857]><CT>"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(FlashAssistedKill::class);
    expect($model->type)->toBe('FlashAssistedKill');
    expect($model->assister)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
});

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

test('Molotov Spawned', function () {
    $log = 'L 01/10/2024 - 20:43:33: Molotov projectile spawned at -1329.640015 -1124.735352 59.975124, velocity 582.460632 595.014771 367.838104';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MolotovSpawned::class);
    expect($model->type)->toBe('MolotovSpawned');
    expect($model->spawnPosX)->toBe(-1329.640015);
    expect($model->spawnPosY)->toBe(-1124.735352);
    expect($model->spawnPosZ)->toBe(59.975124);
    expect($model->velocityPosX)->toBe(582.460632);
    expect($model->velocityPosY)->toBe(595.014771);
    expect($model->velocityPosZ)->toBe(367.838104);
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
