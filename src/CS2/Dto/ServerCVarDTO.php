<?php

namespace CSLog\CS2\Dto;

class ServerCVarDTO
{
    public function __construct(
        public readonly string $timestamp,
        public readonly string $cvar,
        public readonly string|int|float|bool|null $value,
        public readonly string $rawValue,
    ) {}
}
