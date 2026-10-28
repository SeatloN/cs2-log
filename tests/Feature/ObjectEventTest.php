<?php
use CSLog\CS2\Models\BombEvent;
use CSLog\CS2\Models\MolotovSpawned;
use CSLog\CS2\Models\MoneyChanged;
use CSLog\CS2\Models\PickedUp;
use CSLog\CS2\Models\Purchased;
use CSLog\CS2\Models\Threw;
use CSLog\CS2\Patterns;
use CSLog\CS2\PlayerIdentity;

test('GotTheBomb', function () {
    $log = 'L 10/01/2023 - 16:37:01: "Scriib<8><[U:1:94156635]><TERRORIST>" triggered "Got_The_Bomb"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombEvent::class);
    expect($model->type)->toBe('BombEvent');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->event)->toBe('Got_The_Bomb');
});

test('Purchased', function () {
    $log = 'L 10/01/2023 - 16:38:28: "Elix<3><[U:1:302549372]><TERRORIST>" purchased "sawedoff"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Purchased::class);
    expect($model->type)->toBe('Purchased');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->object)->toBe('sawedoff');
});

test('Threw - flash', function () {
    $log = 'L 10/01/2023 - 16:56:14: "index<4><[U:1:98202654]><TERRORIST>" threw flashbang [1172 435 158] flashbang entindex 930)';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Threw::class);
    expect($model->type)->toBe('Threw');

    expect($model->thrower)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->thrower->name)->toBe('index');
    expect($model->thrower->steamId)->toBe('[U:1:98202654]');
    expect($model->thrower->team)->toBe('TERRORIST');
    expect($model->item)->toBe('flashbang');
    expect($model->entindex)->toBe(930);
    expect($model->posX)->toBe(1172);
    expect($model->posY)->toBe(435);
    expect($model->posZ)->toBe(158);
});

test('Picked Up', function () {
    $log = 'L 10/01/2023 - 16:58:37: "SeatloN<2><[U:1:6318168]><TERRORIST>" picked up "molotov"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(PickedUp::class);
    expect($model->type)->toBe('PickedUp');
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->player->name)->toBe('SeatloN');
    expect($model->player->steamId)->toBe('[U:1:6318168]');
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

test('Threw - smoke', function () {
    $log = 'L 10/01/2023 - 16:58:37: "Scriib<8><[U:1:94156635]><CT>" threw smokegrenade [735 2440 138]';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(Threw::class);
    expect($model->type)->toBe('Threw');

    expect($model->thrower)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->thrower->name)->toBe('Scriib');
    expect($model->thrower->steamId)->toBe('[U:1:94156635]');
    expect($model->thrower->team)->toBe('CT');
    expect($model->item)->toBe('smokegrenade');
    expect($model->entindex)->toBeNull();
    expect($model->posX)->toBe(735);
    expect($model->posY)->toBe(2440);
    expect($model->posZ)->toBe(138);
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