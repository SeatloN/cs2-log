<?php

namespace CSLog\CS2\Models;

use Carbon\Carbon;
use CSLog\CS2\CommonPatterns;
use CSLog\CS2\PlayerIdentity;
use CSLog\CS2\Traits\ParsesTimestamp;
use CSLog\CS2\ValueObjects\Vector3;
use CSLog\Model;

class Kill extends Model
{
    /* The `use ParsesTimestamp;` statement in the `Kill` class indicates that the class is using a
    trait called `ParsesTimestamp`. Traits are a way to reuse methods in multiple classes. In this
    case, the `ParsesTimestamp` trait likely contains methods related to parsing timestamps. */
    use ParsesTimestamp;

    /* The `public const PATTERN` in the `Kill` class is defining a regular expression pattern that is
    used to match and extract specific information from a string. Let's break down the pattern step
    by step: */
    public const PATTERN = '/'.CommonPatterns::PREFIX_CLASSIC
        .'(?P<killer>'.CommonPatterns::IDENTITY_INNER.') '
        .CommonPatterns::KILLER_VECTOR.' '
        .'killed '
        .'(?P<killed>'.CommonPatterns::IDENTITY_INNER.') '
        .CommonPatterns::KILLED_VECTOR.' '
        .'with "(?P<weapon>'.CommonPatterns::WEAPON.')"'
        .CommonPatterns::FLAGS.'/';

    /* The line `public string  = 'Kill';` in the `Kill` class is declaring a public property
    named `` with a default value of `'Kill'`. This property is a string type and is
    initialized with the value `'Kill'`. It seems to be indicating the type of the object being
    represented by an instance of the `Kill` class, in this case, denoting that it represents a kill
    event in the context of the application or system where this class is used. */
    public string $type = 'Kill';

    public Carbon $timestamp;

    public PlayerIdentity $killer;

    public Vector3 $killerPos;

    public PlayerIdentity $killed;

    public Vector3 $killedPos;

    /* The line `public string ;` in the `Kill` class is declaring a public property named
    `` with a type hint of `string`. This property is used to store the information about the
    weapon used in the kill event. By declaring it as a public property, it can be accessed and
    modified from outside the class, allowing other parts of the application to interact with and
    retrieve the weapon information associated with a `Kill` object. */
    public string $weapon;

    /* The line `public ?array  = null;` in the `Kill` class is declaring a public property named
    `` with a type hint of `array` that can also be `null`. */
    public ?array $flags = null;

    /**
     * The function constructs objects from given array matches, extracting specific values and parsing
     * flags.
     *
     * @param array matches The `matches` parameter in the constructor seems to be an array that
     * contains information about a game match. The constructor is extracting specific values from this
     * array such as 'killer', 'killed', and 'flags' to initialize properties of the object being
     * constructed.
     */
    public function __construct(array $matches)
    {
        $killerString = $matches['killer'];
        $killedString = $matches['killed'];
        $flagsString = $matches['flags'] ?? null;

        unset($matches['killer'], $matches['killed'], $matches['flags']);

        parent::__construct($matches);

        $this->killer = PlayerIdentity::fromString($killerString);
        $this->killed = PlayerIdentity::fromString($killedString);
        $this->killerPos = Vector3::fromMatches($matches, 'killer');
        $this->killedPos = Vector3::fromMatches($matches, 'killed');

        $this->flags = CommonPatterns::parseFlags($flagsString);
    }

    public function isHeadshot(): bool
    {
        return in_array('headshot', $this->flags ?? []);
    }

    public function isThroughSmoke(): bool
    {
        return in_array('throughsmoke', $this->flags ?? []);
    }

    public function isPenetrated(): bool
    {
        return in_array('penetrated', $this->flags ?? []);
    }
}
