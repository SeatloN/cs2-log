<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

/**
 * Round Statistics from JSON blocks
 * This is a special model that gets constructed differently since it spans multiple lines
 *
 * @phpstan-type PlayerStats array{
 *     accountid: int, team: int, money: int, kills: int, deaths: int,
 *     assists: int, damage: float, hsp: float, kdr: float, adr: int,
 *     mvp: int, ef: int, ud: int, triple_kills: int, quad_kills: int,
 *     ace: int, clutch_kills: int, first_kills: int, pistol_kills: int,
 *     sniper_kills: int, blind_kills: int, bomb_kills: int,
 *     fire_damage: float, unique_kills: float, dinks: int, chicken_kills: int
 * }
 */
class RoundStats extends Model
{
    use ParsesTimestamp;

    public const PATTERN = null; // Doesn't use regex pattern matching

    public string $type = 'RoundStats';

    public Carbon $timestamp;

    public ?string $name = null;

    public int $roundNumber = 0;

    public int $scoreT = 0;

    public int $scoreCT = 0;

    public ?string $map = null;

    public ?string $server = null;

    /** @var array<string, self::PlayerStats> */
    public array $players = [];

    public string $rawJson = '';

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    /** @return self::PlayerStats */
    public static function parsePlayerStats(string $statsString): array
    {
        $values = array_map('trim', explode(',', $statsString));

        return [
            'accountid' => (int) ($values[0] ?? 0),
            'team' => (int) ($values[1] ?? 0),
            'money' => (int) ($values[2] ?? 0),
            'kills' => (int) ($values[3] ?? 0),
            'deaths' => (int) ($values[4] ?? 0),
            'assists' => (int) ($values[5] ?? 0),
            'damage' => (float) ($values[6] ?? 0),
            'hsp' => (float) ($values[7] ?? 0),
            'kdr' => (float) ($values[8] ?? 0),
            'adr' => (int) ($values[9] ?? 0),
            'mvp' => (int) ($values[10] ?? 0),
            'ef' => (int) ($values[11] ?? 0),
            'ud' => (int) ($values[12] ?? 0),
            'triple_kills' => (int) ($values[13] ?? 0),
            'quad_kills' => (int) ($values[14] ?? 0),
            'ace' => (int) ($values[15] ?? 0),
            'clutch_kills' => (int) ($values[16] ?? 0),
            'first_kills' => (int) ($values[17] ?? 0),
            'pistol_kills' => (int) ($values[18] ?? 0),
            'sniper_kills' => (int) ($values[19] ?? 0),
            'blind_kills' => (int) ($values[20] ?? 0),
            'bomb_kills' => (int) ($values[21] ?? 0),
            'fire_damage' => (float) ($values[22] ?? 0),
            'unique_kills' => (float) ($values[23] ?? 0),
            'dinks' => (int) ($values[24] ?? 0),
            'chicken_kills' => (int) ($values[25] ?? 0),
        ];
    }

    public static function fromRawJson(string $timestamp, string $rawJson): self
    {
        $normalized = self::normalizeValveJson($rawJson);
        $json = json_decode($normalized, true);

        if (! is_array($json)) {
            throw new \RuntimeException('Invalid RoundStats JSON block');
        }

        $players = [];
        if (isset($json['players'])) {
            foreach ($json['players'] as $key => $statsString) {
                $players[$key] = self::parsePlayerStats($statsString);
            }
        }

        return new self([
            'timestamp' => $timestamp,
            'name' => $json['name'] ?? null,
            'roundNumber' => (int) ($json['round_number'] ?? 0),
            'scoreT' => (int) ($json['score_t'] ?? 0),
            'scoreCT' => (int) ($json['score_ct'] ?? 0),
            'map' => $json['map'] ?? null,
            'server' => $json['server'] ?? null,
            'players' => $players,
            'rawJson' => $normalized,
        ]);

    }

    private static function normalizeValveJson(string $raw): string
    {
        // Remove control characters except newline, tab, carriage return
        $raw = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $raw);

        // Insert missing commas between JSON fields
        $raw = preg_replace('/"\s*\n\s*"/', '", "', $raw);

        // Insert missing commas between object entries
        $raw = preg_replace('/"\s*\n\s*([a-zA-Z0-9_]+")/', '", "$1', $raw);

        // Remove trailing commas before } or ]
        $raw = preg_replace('/,\s*([}\]])/', '$1', $raw);

        // Collapse multi-line quoted strings
        $raw = preg_replace_callback(
            '/"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"/s',
            fn ($m) => '"'.preg_replace('/\s+/', ' ', $m[1]).'"',
            $raw
        );

        return trim($raw);
    }
}
