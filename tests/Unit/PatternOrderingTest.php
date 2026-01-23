<?php

use CSLog\CS2\Patterns;

it('ensures patterns are ordered by specificity', function () {
    $original = Patterns::all();
    $expected = Patterns::autoReorder();

    // If they differ, dump the diff for developer visibility
    if ($original !== $expected) {
        dump([
            'expected_order' => array_keys($expected),
            'actual_order' => array_keys($original),
        ]);
    }

    expect($original)->toEqual($expected);
});
