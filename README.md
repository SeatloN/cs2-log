# Counter-Strike log parsing in PHP

<!-- [![Latest Version on Packagist](https://img.shields.io/packagist/v/hjbdev/cs-log-parser-php.svg?style=flat-square)](https://packagist.org/packages/hjbdev/cs-log-parser-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/hjbdev/cs-log-parser-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hjbdev/cs-log-parser-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/hjbdev/cs-log-parser-php.svg?style=flat-square)](https://packagist.org/packages/hjbdev/cs-log-parser-php) -->

Parsing Counter-Strike (2) logs in PHP. Provides typed objects for each log and a class for matching individual log lines.


## Installation

You can install the package via composer:

```bash
composer require seatlon/cs2-log
```

## Usage Examples

### Basic Usage (Line by Line - Backwards Compatible)

```php
use CSLog\CS2\Patterns;

$lines = file('server.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    $event = Patterns::match($line);
    
    if ($event) {
        // Process event
    }
}
```

### Advanced Usage (Full Parser with Carbon)

```php
use CSLog\CS2\Parser;
use CSLog\CS2\Models\RoundStats;
use CSLog\CS2\Models\TeamPlaying;
use CSLog\CS2\Models\ServerCVar;
use CSLog\CS2\Models\Kill;

$logContent = file_get_contents('server.log');
$parser = new Parser();
$events = $parser->parse($logContent);

foreach ($events as $event) {
    if ($event instanceof RoundStats) {
        echo "Round {$event->roundNumber} at {$event->timestamp->format('H:i:s')}\n";
        echo "Score: CT {$event->scoreCT} - {$event->scoreT} T\n";
        
        foreach ($event->players as $playerKey => $stats) {
            if ($stats['accountid'] > 0) {
                echo "  {$stats['accountid']}: {$stats['kills']}K / {$stats['deaths']}D\n";
            }
        }
    } elseif ($event instanceof TeamPlaying) {
        echo "Team {$event->side}: {$event->teamName}\n";
        echo "Assigned at: {$event->timestamp->format('H:i:s')}\n";
    } elseif ($event instanceof ServerCVar) {
        echo "Server setting: {$event->cvar} = {$event->value}\n";
    } elseif ($event instanceof Kill) {
        echo "{$event->attacker->name} killed {$event->victim->name}\n";
        echo "Time: {$event->timestamp->diffForHumans()}\n";
    }
}
```

### Working with Carbon Timestamps

```php
use Carbon\Carbon;

// Filter events by time
$recentEvents = array_filter($events, function($event) {
    return $event->timestamp->isAfter(Carbon::now()->subHour());
});

// Get events from specific date
$dateEvents = array_filter($events, function($event) {
    return $event->timestamp->isSameDay('2026-01-19');
});

// Group events by hour
$hourlyGroups = collect($events)->groupBy(function($event) {
    return $event->timestamp->format('Y-m-d H:00');
});

// Calculate time differences
$firstEvent = $events[0];
$lastEvent = end($events);
$duration = $firstEvent->timestamp->diffInMinutes($lastEvent->timestamp);
echo "Match duration: {$duration} minutes\n";
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Alexander Nilsson (SeatloN)](https://github.com/SeatloN)
- [Harry (hjbdev)](https://github.com/hjbdev)
- [All Contributors](../../contributors)
- [eBot](https://github.com/deStrO/eBot-CSGO) (for some of the original Global Offensive patterns, which I have updated and refined for CS2)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Docker Build Command
```bash
docker build -t cs2-log .
```

## Docker Run Command
```bash
docker run --rm --tty cs2-log
```