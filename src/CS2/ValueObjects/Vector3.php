<?php

namespace CSLog\CS2\ValueObjects;

class Vector3
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly int $z,
    ) {}

    public static function fromMatches(array $m, string $prefix = ''): self
    {
        return new self(
            (int) $m[$prefix.'X'],
            (int) $m[$prefix.'Y'],
            (int) $m[$prefix.'Z'],
        );
    }

    public function distanceTo(self $other): float
    {
        return sqrt(
            ($this->x - $other->x) ** 2 +
            ($this->y - $other->y) ** 2 +
            ($this->z - $other->z) ** 2
        );
    }

    public function normalize(): self
    {
        $len = $this->distanceTo(new self(0, 0, 0));

        return new self(
            $this->x / $len,
            $this->y / $len,
            $this->z / $len,
        );
    }

    public function toArray(): array
    {
        return ['x' => $this->x, 'y' => $this->y, 'z' => $this->z];
    }
}
