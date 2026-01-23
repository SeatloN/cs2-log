<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

abstract class SayBase extends Model
{
    use ParsesTimestamp;

    public Carbon $timestamp;

    public PlayerIdentity $player;

    public string $text;

    public function __construct(array $matches)
    {
        // Extract identity block
        $playerString = $matches['player'];
        unset($matches['player']);

        parent::__construct($matches);

        $this->player = PlayerIdentity::fromString($playerString);
        $this->text = $matches['text'];
    }
}
