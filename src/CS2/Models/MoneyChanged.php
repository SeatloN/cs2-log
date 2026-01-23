<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\Model;

class MoneyChanged extends Model
{
    use ParsesTimestamp;

    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<player>'.CommonPatterns::IDENTITY_INNER.') '
        .'money change (?P<before>-?\d+)(?P<operation>[+-])(?P<amount>\d+) = \$(?P<bank>\d+) \(tracked\)'
        .'(?: \((?P<action_type>purchase|acquire): (?P<action_detail>.*)\))?/'; // Made optional

    public string $type = 'MoneyChanged';

    public Carbon $timestamp;

    public PlayerIdentity $player;

    public int $before;

    public string $operation; // '+' or '-'

    public int $amount;

    public int $bank;

    public ?string $actionType = null; // 'purchase' or 'acquire' - nullable

    public ?string $actionDetail = null; // e.g., 'weapon_ak47', 'sellback' - nullable

    public function __construct(array $matches)
    {
        // Convert player identity before parent constructor
        $playerString = $matches['player'];
        unset($matches['player']);

        parent::__construct($matches);

        $this->player = PlayerIdentity::fromString($playerString);
        $this->before = (int) $matches['before'];
        $this->operation = $matches['operation'];
        $this->amount = (int) $matches['amount'];
        $this->bank = (int) $matches['bank'];

        // Only set if present
        if (isset($matches['action_type']) && $matches['action_type'] !== '') {
            $this->actionType = $matches['action_type'];
        }
        if (isset($matches['action_detail']) && $matches['action_detail'] !== '') {
            $this->actionDetail = $matches['action_detail'];
        }
    }

    public function isPurchase(): bool
    {
        return $this->actionType === 'purchase';
    }

    public function isRefund(): bool
    {
        return $this->actionType === 'acquire' && $this->actionDetail === 'sellback';
    }

    public function isAcquire(): bool
    {
        return $this->actionType === 'acquire';
    }
}
