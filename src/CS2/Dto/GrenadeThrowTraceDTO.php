<?php

namespace CSLog\CS2\Dto;

class GrenadeThrowTraceDTO
{
    /**
     * @param  array{0: float, 1: float, 2: float}  $origin
     * @param  array{0: float, 1: float, 2: float}  $angles
     * @param  array{0: float, 1: float, 2: float}  $velocity
     * @param  array{0: float, 1: float, 2: float}  $angularVelocity
     */
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
