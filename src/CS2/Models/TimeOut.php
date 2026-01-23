<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class TimeOut extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'Match pause is (?P<status>enabled|disabled)(?: - (?P<reason>.+))?$/';

    public const TERRORIST_TIMEOUT = 'terrorist_timeout';

    public const CT_TIMEOUT = 'ct_timeout';

    public const TECHNICAL_TIMEOUT = 'technical_timeout';

    public const UNPAUSE = 'unpause';

    public const UNKNOWN_TIMEOUT = 'unknown_timeout';

    public string $type = 'TimeOut';

    public Carbon $timestamp;

    public string $status; // 'enabled' or 'disabled'

    public ?string $reason = null;

    public ?string $timeOutType = null;

    public ?string $team = null;

    public function __construct($data = [])
    {
        parent::__construct($data);

        // Only process timeout type if pause is being enabled
        if ($this->status === 'enabled' && $this->reason) {
            switch ($this->reason) {
                case 'TimeOutTs':
                    $this->timeOutType = self::TERRORIST_TIMEOUT;
                    $this->team = 'TERRORIST';
                    break;
                case 'TimeOutCt':
                    $this->timeOutType = self::CT_TIMEOUT;
                    $this->team = 'CT';
                    break;
                case 'mp_pause_match':
                    $this->timeOutType = self::TECHNICAL_TIMEOUT;
                    break;
                case 'mp_unpause_match':
                    $this->timeOutType = self::UNPAUSE;
                    break;
                default:
                    $this->timeOutType = self::UNKNOWN_TIMEOUT;
                    break;
            }
        }
    }

    public function isPauseEnabled(): bool
    {
        return $this->status === 'enabled';
    }

    public function isPauseDisabled(): bool
    {
        return $this->status === 'disabled';
    }
}
