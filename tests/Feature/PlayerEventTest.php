<?php

use CSLog\CS2\Models\ChangeName;
use CSLog\CS2\Models\Connected;
use CSLog\CS2\Models\Disconnected;
use CSLog\CS2\Models\EnteredTheGame;
use CSLog\CS2\Models\LeftBuyZone;
use CSLog\CS2\Models\Say;
use CSLog\CS2\Patterns;
use CSLog\CS2\PlayerIdentity;

test('Say', function () {
    $log = 'L 06/29/2023 - 19:58:01: "boro494<5><STEAM_1:0:52867709><TERRORIST>" say "kto hraje wipo bajo? saltovsky?"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Say::class);
    expect($model->type)->toBe('Say');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->player->name)->toBe('boro494');
    expect($model->player->steamId)->toBe('STEAM_1:0:52867709');
    expect($model->text)->toBe('kto hraje wipo bajo? saltovsky?');
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