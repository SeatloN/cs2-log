<?php

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
use CSLog\CS2\Models\SwitchTeam;
use CSLog\CS2\Models\TeamScored;
use CSLog\CS2\Models\Threw;
use CSLog\CS2\Models\TimeOut;
use CSLog\CS2\Models\WarmupEnd;
use CSLog\CS2\Patterns;

test('Attack', function () {
    $log = 'L 10/01/2023 - 16:31:58: "GEO<0><[U:1:353168853]><CT>" [-884 537 -32] attacked "Elix<3><[U:1:302549372]><TERRORIST>" [-1035 564 -47] with "m4a1" (damage "90") (damage_armor "19") (health "10") (armor "81") (hitgroup "head")';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Attack::class);
    expect($model->type)->toBe('Attack');
    expect($model->attackerName)->toBe('GEO');
    expect($model->attackerId)->toBe('0');
    expect($model->attackerSteamId)->toBe('[U:1:353168853]');
    expect($model->attackerTeam)->toBe('CT');
    expect($model->attackerX)->toBe(-884);
    expect($model->attackerY)->toBe(537);
    expect($model->attackerZ)->toBe(-32);
    expect($model->attackerWeapon)->toBe('m4a1');
    expect($model->attackerDamage)->toBe(90);
    expect($model->attackerDamageArmor)->toBe(19);
    expect($model->victimHitGroup)->toBe('head');
    expect($model->victimName)->toBe('Elix');
    expect($model->victimId)->toBe('3');
    expect($model->victimSteamId)->toBe('[U:1:302549372]');
    expect($model->victimTeam)->toBe('TERRORIST');
    expect($model->victimX)->toBe(-1035);
    expect($model->victimY)->toBe(564);
    expect($model->victimZ)->toBe(-47);
    expect($model->victimHealth)->toBe(10);
    expect($model->victimArmor)->toBe(81);
});

test('Blinded', function () {
    $log = 'L 10/01/2023 - 16:58:41: "Kaph<6><[U:1:149882025]><CT>" blinded for 1.01 by "Scriib<8><[U:1:94156635]><CT>" from flashbang entindex 568';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Blinded::class);
    expect($model->type)->toBe('Blinded');

    expect($model->victimId)->toBe('6');
    expect($model->victimName)->toBe('Kaph');
    expect($model->victimTeam)->toBe('CT');
    expect($model->victimSteamId)->toBe('[U:1:149882025]');
    expect($model->time)->toBe(1.01);
    expect($model->throwerUserId)->toBe('8');
    expect($model->throwerName)->toBe('Scriib');
    expect($model->throwerTeam)->toBe('CT');
    expect($model->throwerSteamId)->toBe('[U:1:94156635]');
    expect($model->entindex)->toBe(568);
});

test('BombDefusing', function () {
    $log = 'L 10/01/2023 - 16:49:35: "index<4><[U:1:98202654]><CT>" triggered "Begin_Bomb_Defuse_Without_Kit"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombDefusing::class);
    expect($model->userId)->toBe('4');
    expect($model->userName)->toBe('index');
    expect($model->userTeam)->toBe('CT');
    expect($model->steamId)->toBe('[U:1:98202654]');
});

test('BombPlanting', function () {
    $log = 'L 10/01/2023 - 16:53:03: "Kaph<6><[U:1:149882025]><TERRORIST>" triggered "Bomb_Begin_Plant" at bombsite B';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombPlanting::class);
    expect($model->userId)->toBe('6');
    expect($model->userName)->toBe('Kaph');
    expect($model->userTeam)->toBe('TERRORIST');
    expect($model->steamId)->toBe('[U:1:149882025]');
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
    expect($model->userId)->toBe('4');
    expect($model->userName)->toBe('majky');
    expect($model->userTeam)->toBe('Unassigned');
    expect($model->steamId)->toBe('STEAM_1:0:436676464');
    expect($model->newName)->toBe('majkycs');
});

test('Connected', function () {
    $log = 'L 10/01/2023 - 16:32:46: "Scriib<8><[U:1:94156635]><>" connected, address "127.0.0.1:1234"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Connected::class);
    expect($model->type)->toBe('Connected');
    expect($model->userId)->toBe('8');
    expect($model->userName)->toBe('Scriib');
    expect($model->steamId)->toBe('[U:1:94156635]');
    expect($model->address)->toBe('127.0.0.1:1234');
});

test('Disconnected', function () {
    $log = 'L 10/01/2023 - 17:18:54: "Elix<3><[U:1:302549372]><TERRORIST>" disconnected (reason "NETWORK_DISCONNECT_DISCONNECT_BY_USER")';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Disconnected::class);
    expect($model->type)->toBe('Disconnected');
    expect($model->userId)->toBe('3');
    expect($model->userName)->toBe('Elix');
    expect($model->steamId)->toBe('[U:1:302549372]');
    expect($model->userTeam)->toBe('TERRORIST');
    expect($model->reason)->toBe('NETWORK_DISCONNECT_DISCONNECT_BY_USER');
});

test('EnteredTheGame', function () {
    $log = 'L 10/01/2023 - 16:31:24: "GEO<0><[U:1:353168853]><>" entered the game';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(EnteredTheGame::class);
    expect($model->type)->toBe('EnteredTheGame');
    expect($model->userId)->toBe('0');
    expect($model->userName)->toBe('GEO');
    expect($model->steamId)->toBe('[U:1:353168853]');
});

test('GotTheBomb', function () {
    $log = 'L 10/01/2023 - 16:37:01: "Scriib<8><[U:1:94156635]><TERRORIST>" triggered "Got_The_Bomb"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(GotTheBomb::class);
    expect($model->type)->toBe('GotTheBomb');
    expect($model->userName)->toBe('Scriib');
    expect($model->userId)->toBe('8');
    expect($model->team)->toBe('TERRORIST');
    expect($model->steamId)->toBe('[U:1:94156635]');
});

test('Kill', function () {
    $log = 'L 10/01/2023 - 16:32:00: "GEO<0><[U:1:353168853]><CT>" [-835 525 -32] killed "Elix<3><[U:1:302549372]><TERRORIST>" [-762 615 -30] with "m4a1_silencer"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Kill::class);
    expect($model->type)->toBe('Kill');
    expect($model->killerId)->toBe('0');
    expect($model->killerName)->toBe('GEO');
    expect($model->killerSteamId)->toBe('[U:1:353168853]');
    expect($model->killerTeam)->toBe('CT');
    expect($model->killerX)->toBe(-835);
    expect($model->killerY)->toBe(525);
    expect($model->killerZ)->toBe(-32);
    expect($model->killedName)->toBe('Elix');
    expect($model->killedId)->toBe('3');
    expect($model->killedSteamId)->toBe('[U:1:302549372]');
    expect($model->killedTeam)->toBe('TERRORIST');
    expect($model->killedX)->toBe(-762);
    expect($model->killedY)->toBe(615);
    expect($model->killedZ)->toBe(-30);
    expect($model->weapon)->toBe('m4a1_silencer');
    expect($model->headshot)->toBe('');
});

test('KillHeadshot', function () {
    $log = 'L 10/01/2023 - 16:32:00: "GEO<0><[U:1:353168853]><CT>" [-835 525 -32] killed "Elix<3><[U:1:302549372]><TERRORIST>" [-762 615 -30] with "m4a1_silencer" (headshot)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Kill::class);
    expect($model->type)->toBe('Kill');
    expect($model->killerId)->toBe('0');
    expect($model->killerName)->toBe('GEO');
    expect($model->killerSteamId)->toBe('[U:1:353168853]');
    expect($model->killerTeam)->toBe('CT');
    expect($model->killerX)->toBe(-835);
    expect($model->killerY)->toBe(525);
    expect($model->killerZ)->toBe(-32);
    expect($model->killedName)->toBe('Elix');
    expect($model->killedId)->toBe('3');
    expect($model->killedSteamId)->toBe('[U:1:302549372]');
    expect($model->killedTeam)->toBe('TERRORIST');
    expect($model->killedX)->toBe(-762);
    expect($model->killedY)->toBe(615);
    expect($model->killedZ)->toBe(-30);
    expect($model->weapon)->toBe('m4a1_silencer');
    expect($model->headshot)->toBe(' (headshot)');
});

test('KillThroughSmoke', function () {
    $log = 'L 10/01/2023 - 16:32:00: "GEO<0><[U:1:353168853]><CT>" [-835 525 -32] killed "Elix<3><[U:1:302549372]><TERRORIST>" [-762 615 -30] with "m4a1_silencer" (throughsmoke)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Kill::class);
    expect($model->type)->toBe('Kill');
    expect($model->killerId)->toBe('0');
    expect($model->killerName)->toBe('GEO');
    expect($model->killerSteamId)->toBe('[U:1:353168853]');
    expect($model->killerTeam)->toBe('CT');
    expect($model->killerX)->toBe(-835);
    expect($model->killerY)->toBe(525);
    expect($model->killerZ)->toBe(-32);
    expect($model->killedName)->toBe('Elix');
    expect($model->killedId)->toBe('3');
    expect($model->killedSteamId)->toBe('[U:1:302549372]');
    expect($model->killedTeam)->toBe('TERRORIST');
    expect($model->killedX)->toBe(-762);
    expect($model->killedY)->toBe(615);
    expect($model->killedZ)->toBe(-30);
    expect($model->weapon)->toBe('m4a1_silencer');
    expect($model->headshot)->toBe(' (throughsmoke)');
});

test('KillThroughWall', function () {
    $log = 'L 10/01/2023 - 16:32:00: "GEO<0><[U:1:353168853]><CT>" [-835 525 -32] killed "Elix<3><[U:1:302549372]><TERRORIST>" [-762 615 -30] with "m4a1_silencer" (penetrated)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Kill::class);
    expect($model->type)->toBe('Kill');
    expect($model->killerId)->toBe('0');
    expect($model->killerName)->toBe('GEO');
    expect($model->killerSteamId)->toBe('[U:1:353168853]');
    expect($model->killerTeam)->toBe('CT');
    expect($model->killerX)->toBe(-835);
    expect($model->killerY)->toBe(525);
    expect($model->killerZ)->toBe(-32);
    expect($model->killedName)->toBe('Elix');
    expect($model->killedId)->toBe('3');
    expect($model->killedSteamId)->toBe('[U:1:302549372]');
    expect($model->killedTeam)->toBe('TERRORIST');
    expect($model->killedX)->toBe(-762);
    expect($model->killedY)->toBe(615);
    expect($model->killedZ)->toBe(-30);
    expect($model->weapon)->toBe('m4a1_silencer');
    expect($model->headshot)->toBe(' (penetrated)');
});

test('BombKill', function () {
    $log = 'L 01/10/2024 - 20:38:47: "sjuush<7><[U:1:200443857]><CT>" [-586 -856 85] was killed by the bomb.';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombKill::class);
    expect($model->type)->toBe('BombKill');
    expect($model->killedName)->toBe('sjuush');
    expect($model->killedId)->toBe('7');
    expect($model->killedSteamId)->toBe('[U:1:200443857]');
    expect($model->killedTeam)->toBe('CT');
    expect($model->killedX)->toBe(-586);
    expect($model->killedY)->toBe(-856);
    expect($model->killedZ)->toBe(85);
});

test('KillAssist', function () {
    $log = 'L 10/01/2023 - 16:32:16: "Elix<3><[U:1:302549372]><TERRORIST>" assisted killing "GEO<0><[U:1:353168853]><CT>"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(KillAssist::class);
    expect($model->type)->toBe('KillAssist');
    expect($model->assisterId)->toBe('3');
    expect($model->assisterName)->toBe('Elix');
    expect($model->assisterSteamId)->toBe('[U:1:302549372]');
    expect($model->assisterTeam)->toBe('TERRORIST');
    expect($model->killedId)->toBe('0');
    expect($model->killedName)->toBe('GEO');
    expect($model->killedSteamId)->toBe('[U:1:353168853]');
    expect($model->killedTeam)->toBe('CT');
});

test('MatchEnd', function () {
    $log = 'L 10/01/2023 - 17:18:40: Game Over: competitive mg_epic_bomb de_inferno score 15:15 after 42 min';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MatchEnd::class);
    expect($model->type)->toBe('MatchEnd');
    expect($model->mapGroup)->toBe('mg_epic_bomb');
    expect($model->map)->toBe('de_inferno');
    expect($model->scoreA)->toBe(15);
    expect($model->scoreB)->toBe(15);
    expect($model->duration)->toBe(42);
});

test('MatchStart', function () {
    $log = 'L 10/01/2023 - 17:19:10: World triggered "Match_Start" on "de_inferno"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MatchStart::class);
    expect($model->type)->toBe('MatchStart');
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
    expect($model->userId)->toBe('3');
    expect($model->userName)->toBe('Elix');
    expect($model->steamId)->toBe('[U:1:302549372]');
    expect($model->userTeam)->toBe('TERRORIST');
    expect($model->object)->toBe('sawedoff');
});

test('RoundEnd', function () {
    $log = 'L 10/01/2023 - 16:39:30: World triggered "Round_End"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RoundEnd::class);
    expect($model->type)->toBe('RoundEnd');
});

test('RoundRestart', function () {
    $log = 'L 06/29/2023 - 19:42:20: World triggered "Restart_Round_(1_second)"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(RoundRestart::class);
    expect($model->type)->toBe('RoundRestart');
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

    expect($model)->toBeInstanceOf(RoundStart::class);
    expect($model->type)->toBe('RoundStart');
});

test('Say', function () {
    $log = 'L 06/29/2023 - 19:58:01: "boro494<5><STEAM_1:0:52867709><TERRORIST>" say "kto hraje wipo bajo? saltovsky?"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Say::class);
    expect($model->type)->toBe('Say');
    expect($model->userId)->toBe('5');
    expect($model->userName)->toBe('boro494');
    expect($model->userTeam)->toBe('TERRORIST');
    expect($model->steamId)->toBe('STEAM_1:0:52867709');
    expect($model->text)->toBe('kto hraje wipo bajo? saltovsky?');
});

test('SwitchTeam', function () {
    $log = 'L 10/01/2023 - 16:54:57: "GEO<0><[U:1:353168853]>" switched from team <CT> to <TERRORIST>';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(SwitchTeam::class);
    expect($model->type)->toBe('SwitchTeam');
    expect($model->userId)->toBe('0');
    expect($model->userName)->toBe('GEO');
    expect($model->steamId)->toBe('[U:1:353168853]');
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

    expect($model->userId)->toBe('4');
    expect($model->userName)->toBe('index');
    expect($model->userTeam)->toBe('TERRORIST');
    expect($model->steamId)->toBe('[U:1:98202654]');
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

    expect($model->userId)->toBe('8');
    expect($model->userName)->toBe('Scriib');
    expect($model->userTeam)->toBe('CT');
    expect($model->steamId)->toBe('[U:1:94156635]');
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

    expect($model->userId)->toBe('2');
    expect($model->userName)->toBe('SeatloN');
    expect($model->userTeam)->toBe('TERRORIST');
    expect($model->steamId)->toBe('[U:1:6318168]');
    expect($model->object)->toBe('molotov');
});

test('Money Changed', function () {
    $log = 'L 01/09/2024 - 04:04:26.373 - "SeatloN<3><[U:1:6318168]><TERRORIST>" money change 5500-400 = $5100 (tracked) (purchase: weapon_molotov)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MoneyChanged::class);
    expect($model->type)->toBe('MoneyChanged');

    expect($model->userId)->toBe('3');
    expect($model->userName)->toBe('SeatloN');
    expect($model->userTeam)->toBe('TERRORIST');
    expect($model->steamId)->toBe('[U:1:6318168]');
    expect($model->before)->toBe('5500');
    expect($model->cost)->toBe('400');
    expect($model->bank)->toBe('5100');
    expect($model->purchase)->toBe('weapon_molotov');
});

test('Console Say', function () {
    $log = 'L 01/10/2024 - 20:24:22: "Console<0>" say "[CM] ( 1 / 10 ) players online"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(ConsoleSay::class);
    expect($model->type)->toBe('ConsoleSay');

    expect($model->userId)->toBe('0');
    expect($model->userName)->toBe('Console');
    expect($model->text)->toBe('[CM] ( 1 / 10 ) players online');
});

test('Bomb Planted', function () {
    $log = 'L 01/10/2024 - 20:38:06: "FinigaN<6><[U:1:226095351]><TERRORIST>" triggered "Planted_The_Bomb" at bombsite B';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombPlanted::class);
    expect($model->userId)->toBe('6');
    expect($model->userName)->toBe('FinigaN');
    expect($model->userTeam)->toBe('TERRORIST');
    expect($model->steamId)->toBe('[U:1:226095351]');
    expect($model->bombsite)->toBe('B');
});

test('Left Buyzone', function () {
    $log = 'L 01/10/2024 - 21:02:00: "nicoodoz<8><[U:1:112851399]><TERRORIST>" left buyzone with [ weapon_knife_butterfly weapon_glock weapon_ak47 weapon_molotov weapon_hegrenade weapon_smokegrenade kevlar(100) helmet ]';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(LeftBuyZone::class);
    expect($model->userId)->toBe('8');
    expect($model->userName)->toBe('nicoodoz');
    expect($model->userTeam)->toBe('TERRORIST');
    expect($model->userSteamId)->toBe('[U:1:112851399]');
    expect($model->items)->toBe('weapon_knife_butterfly weapon_glock weapon_ak47 weapon_molotov weapon_hegrenade weapon_smokegrenade kevlar(100) helmet');
});

test('Flash Assisted Kill', function () {
    $log = 'L 01/10/2024 - 20:39:24: "znxjez<5><[U:1:23528558]><TERRORIST>" flash-assisted killing "sjuush<7><[U:1:200443857]><CT>"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(FlashAssistedKill::class);
    expect($model->type)->toBe('FlashAssistedKill');
    expect($model->assisterId)->toBe('5');
    expect($model->assisterName)->toBe('znxjez');
    expect($model->assisterSteamId)->toBe('[U:1:23528558]');
    expect($model->assisterTeam)->toBe('TERRORIST');
    expect($model->killedId)->toBe('7');
    expect($model->killedName)->toBe('sjuush');
    expect($model->killedSteamId)->toBe('[U:1:200443857]');
    expect($model->killedTeam)->toBe('CT');
});

test('Timeout Terrorist', function () {
    $log = 'L 01/10/2024 - 20:42:01: rcon from "20.71.36.216:54356": command "timeout_terrorist_start"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(TimeOut::class);
    expect($model->type)->toBe('TimeOut');
    expect($model->address)->toBe('20.71.36.216:54356');
    expect($model->command)->toBe('timeout_terrorist_start');
    expect($model->timeOutType)->toBe('terrorist_timeout');
    expect($model->team)->toBe('TERRORIST');
});

test('Timeout CT', function () {
    $log = 'L 01/10/2024 - 20:42:01: rcon from "20.71.36.216:54356": command "timeout_ct_start"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(TimeOut::class);
    expect($model->type)->toBe('TimeOut');
    expect($model->address)->toBe('20.71.36.216:54356');
    expect($model->command)->toBe('timeout_ct_start');
    expect($model->timeOutType)->toBe('ct_timeout');
    expect($model->team)->toBe('CT');
});

test('Technical TimeOut', function () {
    $log = 'L 01/10/2024 - 20:42:01: rcon from "20.71.36.216:54356": command "mp_pause_match"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(TimeOut::class);
    expect($model->type)->toBe('TimeOut');
    expect($model->address)->toBe('20.71.36.216:54356');
    expect($model->command)->toBe('mp_pause_match');
    expect($model->timeOutType)->toBe('technical_timeout');
    expect($model->team)->toBe('TECH');
});

test('Technical TimeOut Ended', function () {
    $log = 'L 01/10/2024 - 20:42:01: rcon from "20.71.36.216:54356": command "mp_unpause_match"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(TimeOut::class);
    expect($model->type)->toBe('TimeOut');
    expect($model->address)->toBe('20.71.36.216:54356');
    expect($model->command)->toBe('mp_unpause_match');
    expect($model->timeOutType)->toBe('technical_timeout_ended');
    expect($model->team)->toBe('TECH');
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

    expect($model)->toBeInstanceOf(MatchReloaded::class);
    expect($model->type)->toBe('MatchReloaded');
});

test('Match Draw', function () {
    $log = 'L 01/19/2026 - 19:21:35: World triggered "SFUI_Notice_Round_Draw" (CT "11") (T "0")';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(MatchDraw::class);
    expect($model->type)->toBe('MatchDraw');
    expect($model->scoreA)->toBe(11);
    expect($model->scoreB)->toBe(0);
});

test('Backup File Loading', function () {
    $log = 'L 01/19/2026 - 19:21:35: rcon from "20.71.36.216:60696": command "mp_backup_restore_load_file cm_backup_cs2_match_de345abb-a155-4d1f-7839-08de566fc039_round11.txt"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BackupFileLoading::class);
    expect($model->type)->toBe('BackupFileLoading');
    expect($model->ip)->toBe('20.71.36.216:60696');
    expect($model->filename)->toBe('cm_backup_cs2_match_de345abb-a155-4d1f-7839-08de566fc039_round11.txt');
});

test('Backup File Not triggering', function () {
    $log = 'L 01/19/2026 - 18:56:00: rcon from "20.71.36.216:61688": command "mp_backup_round_file_last"';
    $model = Patterns::match($log);

    expect($model)->not->toBeInstanceOf(BackupFileLoading::class);
});

test('Log File Started', function () {
    $log = 'L 01/19/2026 - 18:55:38: Log file started (file "logs//0f870999-5f60-4259-7837-08de566fc039/2026_01_19_185538.log") (game "csgo") (version "10603")';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(LogFileStarted::class);
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
});

test('Warmup End', function () {
    $log = 'L 01/19/2026 - 19:15:32: World triggered "Warmup_End"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(WarmupEnd::class);
    expect($model->type)->toBe('WarmupEnd');
});
