<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

/**
 * @return WorldTriggered{timestamp: Carbon, event: string, map: ?string, restartSeconds: ?int }
 */
class WorldTriggered extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'World triggered "(?P<event>[^"]+)"(?: on "(?P<map>[^"]+)")?$/';

    public string $type = 'WorldTriggered';

    public Carbon $timestamp;

    /**
     * What kind of event was triggered
     *
     * @var string{Game_Commencing|Match_Start|Round_Start|Round_End|Warmup_Start|Warmup_End|Restart_Round(_(X_seconds))?}
     */
    public string $event;

    public ?string $map = null;

    public ?int $restartSeconds = null;

    public function __construct(array $matches)
    {

        parent::__construct($matches);

        // Extract seconds from "Restart_Round_(X_seconds)" format
        if (preg_match('/^Restart_Round_\((\d+)_seconds?\)$/', $this->event, $m)) {
            $this->event = 'Restart_Round';
            $this->restartSeconds = (int) $m[1];
        }
    }
}
