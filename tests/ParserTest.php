<?php

namespace Tests;

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

    $this->assertCount(1, $events);
    $this->assertInstanceOf(TeamPlaying::class, $events[0]);
    $this->assertInstanceOf(Carbon::class, $events[0]->timestamp);
    $this->assertEquals('2026-01-19 19:03:11', $events[0]->timestamp->format('Y-m-d H:i:s'));
    $this->assertEquals('CT', $events[0]->side);
    $this->assertEquals('rvls test team 1', $events[0]->teamName);
});

test('can parse server cvar with carbon', function () {
    $log = 'L 01/19/2026 - 19:03:11: server_cvar: "mp_friendlyfire" "true"';

    $parser = new Parser;
    $events = $parser->parse($log);

    $this->assertCount(1, $events);
    $this->assertInstanceOf(ServerCVar::class, $events[0]);
    $this->assertInstanceOf(Carbon::class, $events[0]->timestamp);
    $this->assertEquals('mp_friendlyfire', $events[0]->cvar);
    $this->assertEquals('true', $events[0]->value);
});

test('can parse world triggered with map', function () {
    $log = 'L 01/19/2026 - 19:03:11: World triggered "Match_Start" on "de_inferno"';

    $parser = new Parser;
    $events = $parser->parse($log);

    $this->assertCount(1, $events);
    $this->assertInstanceOf(WorldTriggered::class, $events[0]);
    $this->assertEquals('Match_Start', $events[0]->event);
    $this->assertEquals('de_inferno', $events[0]->map);
});

test('can parse world triggered without map', function () {
    $log = 'L 01/19/2026 - 19:03:11: World triggered "Round_Start"';

    $parser = new Parser;
    $events = $parser->parse($log);

    $this->assertCount(1, $events);
    $this->assertInstanceOf(WorldTriggered::class, $events[0]);
    $this->assertEquals('Round_Start', $events[0]->event);
    $this->assertNull($events[0]->map);
});

test('can use carbon methods on timestamp', function () {
    $log = 'L 01/19/2026 - 19:03:11: Team playing "CT": rvls test team 1';

    $parser = new Parser;
    $events = $parser->parse($log);

    $event = $events[0];

    // Test Carbon methods work
    $this->assertEquals(2026, $event->timestamp->year);
    $this->assertEquals(1, $event->timestamp->month);
    $this->assertEquals(19, $event->timestamp->day);
    $this->assertEquals(19, $event->timestamp->hour);
    $this->assertEquals(3, $event->timestamp->minute);
    $this->assertEquals(11, $event->timestamp->second);
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

    $this->assertCount(1, $events);
    $this->assertInstanceOf(RoundStats::class, $events[0]);
    $this->assertInstanceOf(Carbon::class, $events[0]->timestamp);
    $this->assertEquals('2026-01-19 19:03:11', $events[0]->timestamp->format('Y-m-d H:i:s'));
    $this->assertEquals('round_stats', $events[0]->name);
    $this->assertEquals(1, $events[0]->roundNumber);
    $this->assertEquals('de_inferno', $events[0]->map);
    $this->assertArrayHasKey('player_1', $events[0]->players);
    $this->assertEquals(91379634, $events[0]->players['player_1']['accountid']);
    $this->assertEquals(5, $events[0]->players['player_1']['kills']);
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

    $this->assertCount(1, $events);
    $this->assertInstanceOf(RoundStats::class, $events[0]);
    $this->assertInstanceOf(Carbon::class, $events[0]->timestamp);
    $this->assertEquals('2026-01-19 18:59:47', $events[0]->timestamp->format('Y-m-d H:i:s'));
    $this->assertEquals('round_stats', $events[0]->name);
    $this->assertEquals(1, $events[0]->roundNumber);
    $this->assertEquals('de_inferno', $events[0]->map);
    $this->assertArrayHasKey('player_0', $events[0]->players);
    $this->assertEquals(0, $events[0]->players['player_0']['accountid']);
    $this->assertEquals(0, $events[0]->players['player_0']['team']);
    $this->assertEquals(0, $events[0]->players['player_0']['kills']);

    $this->assertArrayHasKey('player_10', $events[0]->players);
    $this->assertEquals(29856109, $events[0]->players['player_10']['accountid']);
    $this->assertEquals(2, $events[0]->players['player_10']['team']);
    $this->assertEquals(0, $events[0]->players['player_10']['kills']);
}
);
