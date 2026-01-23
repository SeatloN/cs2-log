<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class LeftBuyZone extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<player>'.CommonPatterns::IDENTITY_INNER.') '
        .'left buyzone with \[\s*(?P<items>.*?)\s*\]/';

    public string $type = 'LeftBuyZone';

    public Carbon $timestamp;

    public PlayerIdentity $player;

    public ?string $items = null;

    public function __construct(array $matches)
    {
        $playerString = $matches['player'];
        $itemsString = $matches['items'];
        unset($matches['player']);
        unset($matches['items']);

        parent::__construct($matches);

        $this->player = PlayerIdentity::fromString($playerString);

        // Only set items if the string is not empty
        if (isset($itemsString) && trim($itemsString) !== '') {
            $this->items = trim($itemsString);
        }
    }

    public function hasItems(): bool
    {
        return $this->items !== null;
    }

    public function getItemsArray(): array
    {
        if ($this->items === null) {
            return [];
        }

        return array_map('trim', explode(' ', $this->items));
    }
}
