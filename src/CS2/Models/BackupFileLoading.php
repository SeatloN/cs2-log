<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\LogPrefix;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class BackupFileLoading extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.LogPrefix::CLASSIC.'rcon from "(?P<ip>[^"]+)": command "mp_backup_restore_load_file (?P<filename>[^"]+)"/';

    public string $type = 'BackupFileLoading';

    public Carbon $timestamp;

    public string $ip;

    public string $filename;
}
