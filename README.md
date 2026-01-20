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

## Usage

```php
use CSLog\CS2\Patterns;

$model = Patterns::match($log);
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