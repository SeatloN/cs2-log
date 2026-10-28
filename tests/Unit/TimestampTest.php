<?php

use CSLog\CS2\Patterns;

test('Timestamps parsing', function () {
    // Format 1: L prefix, no milliseconds, colon separator
    $line1 = 'L 01/19/2026 - 19:03:11: Team playing "CT": rvls test team 1';
    $event1 = Patterns::match($line1);
    expect($event1->timestamp->format('Y-m-d H:i:s.v'))->toEqual('2026-01-19 19:03:11.000');

    // Format 2: L prefix, with milliseconds, colon separator
    $line2 = 'L 01/19/2026 - 19:03:11.170: Team playing "CT": rvls test team 1';
    $event2 = Patterns::match($line2);
    expect($event2->timestamp->format('Y-m-d H:i:s.v'))->toEqual('2026-01-19 19:03:11.170');
});
