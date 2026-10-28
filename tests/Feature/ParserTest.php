<?php

use Carbon\Carbon;
use CSLog\CS2\Models\RoundStats;
use CSLog\CS2\Models\ServerCVar;
use CSLog\CS2\Models\TeamPlaying;
use CSLog\CS2\Models\WorldTriggered;
use CSLog\CS2\Parser;


test('can parse team playing with carbon', function () {
    $log = 'L 01/19/2026 - 19:03:11: Team playing "CT": rvls test team 1';

    $parser = new Parser;
    $events = $parser->parse($log);

    expect($events)->toHaveCount(1);
    expect($events[0])->toBeInstanceOf(TeamPlaying::class);
    expect($events[0]->timestamp)->toBeInstanceOf(Carbon::class);
    expect($events[0]->timestamp->format('Y-m-d H:i:s'))->toEqual('2026-01-19 19:03:11');
    expect($events[0]->side)->toEqual('CT');
    expect($events[0]->teamName)->toEqual('rvls test team 1');
});

test('can parse server cvar with carbon', function () {
    $log = 'L 01/19/2026 - 19:03:11: server_cvar: "mp_friendlyfire" "true"';

    $parser = new Parser;
    $events = $parser->parse($log);

    expect($events)->toHaveCount(1);
    expect($events[0])->toBeInstanceOf(ServerCVar::class);
    expect($events[0]->timestamp)->toBeInstanceOf(Carbon::class);
    expect($events[0]->cvar)->toEqual('mp_friendlyfire');
    expect($events[0]->value)->toEqual('true');
});

test('can parse world triggered with map', function () {
    $log = 'L 01/19/2026 - 19:03:11: World triggered "Match_Start" on "de_inferno"';

    $parser = new Parser;
    $events = $parser->parse($log);

    expect($events)->toHaveCount(1);
    expect($events[0])->toBeInstanceOf(WorldTriggered::class);
    expect($events[0]->event)->toEqual('Match_Start');
    expect($events[0]->map)->toEqual('de_inferno');
});

test('can parse world triggered without map', function () {
    $log = 'L 01/19/2026 - 19:03:11: World triggered "Round_Start"';

    $parser = new Parser;
    $events = $parser->parse($log);

    expect($events)->toHaveCount(1);
    expect($events[0])->toBeInstanceOf(WorldTriggered::class);
    expect($events[0]->event)->toEqual('Round_Start');
    expect($events[0]->map)->toBeNull();
});

test('can use carbon methods on timestamp', function () {
    $log = 'L 01/19/2026 - 19:03:11: Team playing "CT": rvls test team 1';

    $parser = new Parser;
    $events = $parser->parse($log);

    $event = $events[0];

    // Test Carbon methods work
    expect($event->timestamp->year)->toEqual(2026);
    expect($event->timestamp->month)->toEqual(1);
    expect($event->timestamp->day)->toEqual(19);
    expect($event->timestamp->hour)->toEqual(19);
    expect($event->timestamp->minute)->toEqual(3);
    expect($event->timestamp->second)->toEqual(11);
});

test('can parse json stats block with carbon', function () {
    $log = <<<'LOG'
L 01/19/2026 - 19:03:11: JSON_BEGIN{
L 01/19/2026 - 19:03:11: "name": "round_stats",
L 01/19/2026 - 19:03:11: "round_number" : "1",
L 01/19/2026 - 19:03:11: "score_t" : "0",
L 01/19/2026 - 19:03:11: "score_ct" : "0",
L 01/19/2026 - 19:03:11: "map" : "de_inferno",
L 01/19/2026 - 19:03:11: "players" : {
L 01/19/2026 - 19:03:11: "player_1" : "91379634,3,0,5,2,1,150.00,60.00,2.50,75,1,0,0,0,0,0,0,2,0,1,0,0,0.000000,0.000000,3,0"
L 01/19/2026 - 19:03:11: }}JSON_END
LOG;

    $parser = new Parser;
    $events = $parser->parse($log);

    expect($events)->toHaveCount(1);
    expect($events[0])->toBeInstanceOf(RoundStats::class);
    expect($events[0]->timestamp)->toBeInstanceOf(Carbon::class);
    expect($events[0]->timestamp->format('Y-m-d H:i:s'))->toEqual('2026-01-19 19:03:11');
    expect($events[0]->name)->toEqual('round_stats');
    expect($events[0]->roundNumber)->toEqual(1);
    expect($events[0]->map)->toEqual('de_inferno');
    expect($events[0]->players)->toHaveKey('player_1');
    expect($events[0]->players['player_1']['accountid'])->toEqual(91379634);
    expect($events[0]->players['player_1']['kills'])->toEqual(5);
}
);

test('can parse json stats block - With more than 1 player', function () {
    $log = <<<'LOG'
L 01/19/2026 - 18:59:47: JSON_BEGIN{
L 01/19/2026 - 18:59:47: "name": "round_stats",
L 01/19/2026 - 18:59:47: "round_number" : "1",
L 01/19/2026 - 18:59:47: "score_t" : "0",
L 01/19/2026 - 18:59:47: "score_ct" : "0",
L 01/19/2026 - 18:59:47: "map" : "de_inferno",
L 01/19/2026 - 18:59:47: "server" : "challengermode.com - Register to join",
L 01/19/2026 - 18:59:47: "fields" : "             accountid,   team,  money,  kills, deaths,assists,    dmg,    hsp,    kdr,    adr,    mvp,     ef,     ud,     3k,     4k,     5k,clutchk, firstk,pistolk,sniperk, blindk,  bombk,firedmg,uniquek,  dinks,chickenk"
L 01/19/2026 - 18:59:47: "players" : {
L 01/19/2026 - 18:59:47: "player_0" : "                   0,      0,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_1" : "            91379634,      3,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_2" : "            91023233,      2,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_3" : "           133954850,      3,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_4" : "           193288330,      3,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_5" : "           442078920,      3,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_6" : "           188337394,      2,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_7" : "           268200068,      2,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_8" : "          1047133778,      2,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_9" : "            97679279,      3,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: "player_10" : "            29856109,      2,      0,      0,      0,      0,   0.00,   0.00,   0.00,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,      0,0.000000,0.000000,      0,      0,      0"
L 01/19/2026 - 18:59:47: }}JSON_END
LOG;

    $parser = new Parser;
    $events = $parser->parse($log);

    expect($events)->toHaveCount(1);
    expect($events[0])->toBeInstanceOf(RoundStats::class);
    expect($events[0]->timestamp)->toBeInstanceOf(Carbon::class);
    expect($events[0]->timestamp->format('Y-m-d H:i:s'))->toEqual('2026-01-19 18:59:47');
    expect($events[0]->name)->toEqual('round_stats');
    expect($events[0]->roundNumber)->toEqual(1);
    expect($events[0]->map)->toEqual('de_inferno');
    expect($events[0]->players)->toHaveKey('player_0');
    expect($events[0]->players['player_0']['accountid'])->toEqual(0);
    expect($events[0]->players['player_0']['team'])->toEqual(0);
    expect($events[0]->players['player_0']['kills'])->toEqual(0);

    expect($events[0]->players)->toHaveKey('player_10');
    expect($events[0]->players['player_10']['accountid'])->toEqual(29856109);
    expect($events[0]->players['player_10']['team'])->toEqual(2);
    expect($events[0]->players['player_10']['kills'])->toEqual(0);
}
);