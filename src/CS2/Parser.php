<?php

namespace CSLog\CS2;

use CSLog\CS2\Models\RoundStats;

class Parser
{
    protected ?array $jsonBlockBuffer = null;

    protected bool $inJsonBlock = false;

    protected array $events = [];

    /**
     * Parse entire log content
     */
    public function parse(string $content): array
    {
        $this->events = [];
        $this->jsonBlockBuffer = null;
        $this->inJsonBlock = false;

        $lines = preg_split("~\R~u", $content, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($lines as $line) {
            $event = $this->parseLine($line);
            if ($event !== null) {
                $this->events[] = $event;
            }
        }

        return $this->events;
    }

    /**
     * Parse a single line
     * Returns null for lines that are part of multi-line blocks
     */
    public function parseLine(string $line): mixed
    {
        // JSON block start
        if ($this->isJsonBegin($line, $timestamp)) {
            $this->startJsonBlock($timestamp);

            return null;
        }

        // Inside JSON block
        if ($this->inJsonBlock && $this->jsonBlockBuffer !== null) {
            // JSON block end on this line
            if ($this->isJsonEndLine($line)) {
                $this->processJsonEndLine($line);
                $event = $this->finalizeJsonBlock();

                return $event;
            }

            // Regular JSON content line
            $this->processJsonLine($line);

            return null;
        }

        // Standard pattern matching for single-line events
        return Patterns::match($line);
    }

    /**
     * Detect JSON_BEGIN line and extract timestamp
     */
    protected function isJsonBegin(string $line, ?string &$timestamp = null): bool
    {
        if (preg_match(
            '/^(?:L )?(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}(?:\.\d{3})?)(?:: | - )JSON_BEGIN\s*\{\s*$/',
            $line,
            $m
        )) {
            $timestamp = $m['timestamp'];

            return true;
        }

        return false;
    }

    /**
     * Detect a line that contains the JSON_END marker
     */
    protected function isJsonEndLine(string $line): bool
    {
        return str_contains($line, 'JSON_END');
    }

    /**
     * Initialize JSON block buffer
     */
    protected function startJsonBlock(?string $timestamp): void
    {
        $this->inJsonBlock = true;
        $this->jsonBlockBuffer = [
            'timestamp' => $timestamp,
            'raw_json' => "{\n", // we synthesize the opening brace
        ];
    }

    /**
     * Process a line within a JSON block (not containing JSON_END)
     */
    protected function processJsonLine(string $line): void
    {
        if (! preg_match(
            '/^(?:L )?(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}(?:\.\d{3})?)(?:: | - )(?P<content>.+)$/',
            $line,
            $m
        )) {
            return;
        }

        $content = rtrim($m['content']);
        $this->jsonBlockBuffer['raw_json'] .= $content."\n";
    }

    /**
     * Process the final line of a JSON block (contains JSON_END)
     */
    protected function processJsonEndLine(string $line): void
    {
        if (! preg_match(
            '/^(?:L )?(?P<timestamp>\d{2}\/\d{2}\/\d{4} - \d{2}:\d{2}:\d{2}(?:\.\d{3})?)(?:: | - )(?P<content>.+)$/',
            $line,
            $m
        )) {
            return;
        }

        $content = $m['content'];

        // Strip the JSON_END marker, keep the closing braces
        $content = preg_replace('/\s*JSON_END\s*$/', '', $content);
        $content = rtrim($content);

        if ($content !== '') {
            $this->jsonBlockBuffer['raw_json'] .= $content."\n";
        }

        $this->inJsonBlock = false;
    }

    /**
     * Finalize JSON block: decode and build RoundStats
     */
    protected function finalizeJsonBlock(): ?RoundStats
    {
        if ($this->jsonBlockBuffer === null) {
            return null;
        }

        $rawJson = $this->jsonBlockBuffer['raw_json'];
        $timestamp = $this->jsonBlockBuffer['timestamp'];
        /*
        // Try to decode JSON
        $decoded = json_decode($rawJson, true);

        $data = [];
        $players = [];

        if (is_array($decoded)) {
            $data = $decoded;

            if (isset($data['players']) && is_array($data['players'])) {
                foreach ($data['players'] as $key => $value) {
                    if (preg_match('/^player_\d+$/', $key)) {
                        $players[$key] = RoundStats::parsePlayerStats($value);
                    }
                }

                // Remove raw players block from data if you only want parsed players
                unset($data['players']);
            }
        }
        */

        $stats = RoundStats::fromRawJson($timestamp, $rawJson);

        $this->jsonBlockBuffer = null;

        return $stats;
    }

    /**
     * Get all parsed events
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * Filter events by type
     */
    public function filterByType(string $className): array
    {
        return array_values(
            array_filter($this->events, fn ($event) => $event instanceof $className)
        );
    }
}
