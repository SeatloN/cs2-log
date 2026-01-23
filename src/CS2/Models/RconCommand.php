<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class RconCommand extends Model
{
    use ParsesTimestamp;

    public const PATTERN =
        '/'.CommonPatterns::PREFIX_CLASSIC
        .'rcon from "(?P<ip>[^"]+)": command "(?P<command>.*)"\s*$/';

    // Timeout types
    public const TERRORIST_TIMEOUT = 'terrorist_timeout';

    public const CT_TIMEOUT = 'ct_timeout';

    public const TECHNICAL_TIMEOUT = 'technical_timeout';

    public const TECHNICAL_TIMEOUT_END = 'technical_timeout_ended';

    // Backup file loading
    public const BACKUP_FILE_LOADING = 'mp_backup_restore_load_file';

    public string $type = 'RconCommand';

    public Carbon $timestamp;

    public string $ip;

    public string $command;

    public string $commandName;

    public ?string $argument = null;

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        // Split command into name + optional argument
        $this->parseCommand();
    }

    private function parseCommand(): void
    {
        $cmd = trim($this->command);

        // Pattern:
        // <name> <argument...>
        // or just <name>
        if (preg_match('/^(?P<name>\S+)(?:\s+(?P<arg>.+))?$/', $cmd, $m)) {
            $this->commandName = $m['name'];
            $this->argument = $m['arg'] ?? null;
        } else {
            // Fallback: whole string is the name
            $this->commandName = $cmd;
            $this->argument = null;
        }
    }

    public function hasArgument(): bool
    {
        return $this->argument !== null;
    }
}
