<?php

use CSLog\CS2\Models\BombDefusing;
use CSLog\CS2\Models\BombKill;
use CSLog\CS2\Models\BombPlanted;
use CSLog\CS2\Models\BombPlanting;
use CSLog\CS2\Patterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\ValueObjects\Vector3;

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

test('Bomb Planted', function () {
    $log = 'L 01/10/2024 - 20:38:06: "FinigaN<6><[U:1:226095351]><TERRORIST>" triggered "Planted_The_Bomb" at bombsite B';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombPlanted::class);
    expect($model->player)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->bombsite)->toBe('B');
});

test('BombKill', function () {
    $log = 'L 01/10/2024 - 20:38:47: "sjuush<7><[U:1:200443857]><CT>" [-586 -856 85] was killed by the bomb.';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(BombKill::class);
    expect($model->type)->toBe('BombKill');
    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killedPos)->toBeInstanceOf(Vector3::class);
});