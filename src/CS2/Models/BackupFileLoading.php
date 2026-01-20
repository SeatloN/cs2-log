<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class BackupFileLoading extends Model
{
    public const PATTERN = '/rcon from "(?P<ip>[^"]+)": command "mp_backup_restore_load_file (?P<filename>[^"]+)"/';

    public string $type = 'BackupFileLoading';

    public string $ip;
    
    public string $filename;
}