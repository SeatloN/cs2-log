<?php

namespace CSLog\CS2\Dto;

class ServerCVarDTO
{
    /**
     * @param  string  $timestamp
     * @param  string  $cvar
     * @param  string|int|float|bool|null  $value
     * @param  string  $rawValue
     */
    public function __construct(
        public readonly string $timestamp,
        public readonly string $cvar,
        public readonly string|int|float|bool|null $value,
        public readonly string $rawValue,
    ) {}
}
