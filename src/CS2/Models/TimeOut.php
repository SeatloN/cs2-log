<?php

namespace CSLog\CS2\Models;

use CSLog\Model;

class TimeOut extends Model
{
    public const PATTERN = '/rcon from "(?P<address>.*)": command "(?P<command>timeout_terrorist_start|timeout_ct_start|mp_pause_match|mp_unpause_match)"/';

    public const TERRORIST_TIMEOUT = 'terrorist_timeout';

    public const CT_TIMEOUT = 'ct_timeout';

    public const TECHNICAL_TIMEOUT = 'technical_timeout';

    public const TECHNICAL_TIMEOUT_END = 'technical_timeout_ended';

    public string $type = 'TimeOut';

    public string $timeOutType;

    public string $team;

    public string $address;

    public string $command;

    public function __construct($data = [])
    {
        parent::__construct($data);

        switch ($this->command) {
            case 'timeout_terrorist_start':
                $this->timeOutType = self::TERRORIST_TIMEOUT;
                $this->team = 'TERRORIST';
                break;
            case 'timeout_ct_start':
                $this->timeOutType = self::CT_TIMEOUT;
                $this->team = 'CT';
                break;
            case 'mp_pause_match':
                $this->timeOutType = self::TECHNICAL_TIMEOUT;
                $this->team = 'TECH';
                break;
            case 'mp_unpause_match':
                $this->timeOutType = self::TECHNICAL_TIMEOUT_END;
                $this->team = 'TECH';
                break;
        }
    }
}
