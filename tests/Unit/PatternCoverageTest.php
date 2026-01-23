<?php

use CSLog\CS2\Patterns;

it('ensures all real log lines are matched by exactly one pattern outside JSON blocks', function () {
    $logDir = realpath(__DIR__.'/../Logs');

    if ($logDir === false) {
        throw new Exception('tests/Logs directory not found');
    }

    $files = array_filter(
        scandir($logDir),
        fn ($f) => ! in_array($f, ['.', '..']) && is_file($logDir.'/'.$f)
    );

    expect($files)->not->toBeEmpty();

    $patterns = Patterns::all();

    foreach ($files as $file) {
        $path = $logDir.'/'.$file;
        $lines = file($path, FILE_IGNORE_NEW_LINES);

        $inJsonBlock = false;

        foreach ($lines as $lineNumber => $line) {
            $trim = trim($line);

            if ($trim === '') {
                continue;
            }

            // Detect JSON_BEGIN
            if (preg_match('/JSON_BEGIN\s*\{/', $line)) {
                $inJsonBlock = true;

                continue;
            }

            // Detect JSON_END
            if (preg_match('/\}\}\s*JSON_END/', $line)) {
                $inJsonBlock = false;

                continue;
            }

            // Skip lines inside JSON blocks
            if ($inJsonBlock) {
                continue;
            }

            // Now test patterns normally
            $matches = [];

            foreach ($patterns as $type => $regex) {
                if (preg_match($regex, $line)) {
                    $matches[] = $type;
                }
            }

            if (empty($matches)) {
                throw new Exception("No pattern matched line {$lineNumber} in {$file}: {$line}");
            }

            if (count($matches) > 1) {
                throw new Exception("Multiple patterns matched line {$lineNumber} in {$file}: ".implode(', ', $matches)." | {$line}");
            }
        }
    }

    expect(true)->toBeTrue();
});
