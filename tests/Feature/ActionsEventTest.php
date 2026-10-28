<?php
use CSLog\CS2\Models\Attack;
use CSLog\CS2\Models\Blinded;
use CSLog\CS2\Models\FlashAssistedKill;
use CSLog\CS2\Models\Kill;
use CSLog\CS2\Models\KillAssist;
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
    expect($model->flags)->toBe([]);
    expect($model->isPenetrated())->toBeFalse();
    expect($model->isHeadshot())->toBeFalse();
    expect($model->isThroughSmoke())->toBeFalse();
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
    expect($model->flags)->toBe(['headshot']);
    expect($model->isPenetrated())->toBeFalse();
    expect($model->isHeadshot())->toBeTrue();
    expect($model->isThroughSmoke())->toBeFalse();
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
    expect($model->flags)->toBe(['throughsmoke']);
    expect($model->isPenetrated())->toBeFalse();
    expect($model->isHeadshot())->toBeFalse();
    expect($model->isThroughSmoke())->toBeTrue();
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
    expect($model->flags)->toBe(['penetrated']);
    expect($model->isPenetrated())->toBeTrue();
    expect($model->isHeadshot())->toBeFalse();
    expect($model->isThroughSmoke())->toBeFalse();
});

test('Flash Assisted Kill', function () {
    $log = 'L 01/10/2024 - 20:39:24: "znxjez<5><[U:1:23528558]><TERRORIST>" flash-assisted killing "sjuush<7><[U:1:200443857]><CT>"';
    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(FlashAssistedKill::class);
    expect($model->type)->toBe('FlashAssistedKill');
    expect($model->assister)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
});

test('KillAssist', function () {
    $log = 'L 10/01/2023 - 16:32:16: "Elix<3><[U:1:302549372]><TERRORIST>" assisted killing "GEO<0><[U:1:353168853]><CT>"';

    $model = Patterns::match($log);

    expect($model)->toBeInstanceOf(KillAssist::class);
    expect($model->type)->toBe('KillAssist');
    expect($model->assister)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->assister->name)->toBe('Elix');
    expect($model->assister->steamId)->toBe('[U:1:302549372]');
    expect($model->assister->team)->toBe('TERRORIST');
    expect($model->killed)->toBeInstanceOf(PlayerIdentity::class);
    expect($model->killed->name)->toBe('GEO');
    expect($model->killed->steamId)->toBe('[U:1:353168853]');
    expect($model->killed->team)->toBe('CT');
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