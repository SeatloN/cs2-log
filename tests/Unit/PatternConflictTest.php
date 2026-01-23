<?php

use CSLog\CS2\Patterns;

it('detects conflicting regex patterns', function () {
    $patterns = Patterns::all();
    $conflicts = [];

    foreach ($patterns as $typeA => $regexA) {
        $sample = Patterns::generateSampleLine($regexA);

        if ($sample === null) {
            continue;
        }

        $matches = [];

        foreach ($patterns as $typeB => $regexB) {
            if (preg_match($regexB, $sample)) {
                $matches[] = $typeB;
            }
        }

        if (count($matches) > 1) {
            $conflicts[$typeA] = [
                'sample' => $sample,
                'matches' => $matches,
                'winner' => $matches[0],
            ];
        }
    }

    if (! empty($conflicts)) {
        dump($conflicts);
    }

    expect($conflicts)->toBeEmpty();
});
