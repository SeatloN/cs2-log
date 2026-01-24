<?php

namespace CSLog\CS2\ValueObjects;

class Vector3
{
    /**
     * @param  int  $x  X coordinate.
     * @param  int  $y  Y coordinate.
     * @param  int  $z  Z coordinate.
     */
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly int $z,
    ) {}

    /**
     * Parses a raw log line into a PlayerHurtEvent.
     *
     * @param  string  $m  contains the matches.
     * @param  string  $prefix  optional prefix for the match keys.
     * @return self if the line does not match.
     */
    public static function fromMatches(array $m, string $prefix = ''): self
    {
        return new self(
            (int) $m[$prefix.'X'],
            (int) $m[$prefix.'Y'],
            (int) $m[$prefix.'Z'],
        );
    }

    /**
     * Parses a raw log line into a PlayerHurtEvent.
     *
     * @param  self  $other  The other Vector3 object to calculate distance to.
     * @return float Distance between the two vectors.
     */
    public function distanceTo(self $other): float
    {
        return sqrt(
            ($this->x - $other->x) ** 2 +
            ($this->y - $other->y) ** 2 +
            ($this->z - $other->z) ** 2
        );
    }

    /**
     * Parses a raw log line into a PlayerHurtEvent.
     *
     * @return self Normalized vector.
     */
    public function normalize(): self
    {
        $len = $this->distanceTo(new self(0, 0, 0));

        return new self(
            $this->x / $len,
            $this->y / $len,
            $this->z / $len,
        );
    }

    /**
     * Parses a raw log line into a PlayerHurtEvent.
     *
     * @return array{x: int, y: int, z: int}.
     */
    public function toArray(): array
    {
        return ['x' => $this->x, 'y' => $this->y, 'z' => $this->z];
    }
}
