<?php

namespace CSLog\CS2\DTO;

class GrenadeThrowTraceDTO
{
    public function __construct(
        public string $grenadeType,
        public array $origin,
        public array $angles,
        public array $velocity,
        public array $angularVelocity,
        public int $tickOrFuse,
        public ?float $fuseTime = null, // Only for HE grenades
    ) {}
}
