<?php

use CSLog\CS2\Patterns;

it('scores regex patterns by specificity', function () {
    $ranked = Patterns::rankedBySpecificity();

    dump($ranked);

    expect($ranked)->toBeArray();
    expect($ranked)->not->toBeEmpty();

    // Optional: ensure no pattern has a score of 0 (meaning it's too vague)
    foreach ($ranked as $type => $score) {
        expect($score)->toBeGreaterThan(0);
    }
});
