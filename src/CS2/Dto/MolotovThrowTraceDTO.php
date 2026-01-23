<?php

namespace CSLog\CS2\DTO;

class MolotovThrowTraceDTO
{
    public function __construct(
        public readonly array $origin,            // [x, y, z]
        public readonly array $angles,            // [pitch, yaw, roll]
        public readonly array $velocity,          // [vx, vy, vz]
        public readonly array $angularVelocity,   // [avx, avy, avz]
        public readonly int $tickOrFuse           // 48
    ) {}
}
