<?php

namespace CSLog\CS2\Support;

class VectorMath
{
    /** @param array{0: int|float, 1: int|float, 2: int|float} $v */
    public static function magnitude(array $v): float
    {
        return sqrt($v[0] ** 2 + $v[1] ** 2 + $v[2] ** 2);
    }

    /**
     * @param  array{0: int|float, 1: int|float, 2: int|float}  $a
     * @param  array{0: int|float, 1: int|float, 2: int|float}  $b
     */
    public static function distance(array $a, array $b): float
    {
        return self::magnitude([
            $b[0] - $a[0],
            $b[1] - $a[1],
            $b[2] - $a[2],
        ]);
    }

    /**
     * @param  array{0: int|float, 1: int|float, 2: int|float}  $a
     * @param  array{0: int|float, 1: int|float, 2: int|float}  $b
     */
    public static function dot(array $a, array $b): float
    {
        return $a[0] * $b[0] + $a[1] * $b[1] + $a[2] * $b[2];
    }

    /**
     * @param  array{0: int|float, 1: int|float, 2: int|float}  $v
     * @return array{0: int|float, 1: int|float, 2: int|float}
     */
    public static function normalize(array $v): array
    {
        $mag = self::magnitude($v);

        return $mag == 0 ? [0, 0, 0] : [$v[0] / $mag, $v[1] / $mag, $v[2] / $mag];
    }

    public static function angleBetween(array $a, array $b): float
    {
        $dot = self::dot($a, $b);
        $mag = self::magnitude($a) * self::magnitude($b);

        if ($mag == 0) {
            return 0.0;
        }

        return rad2deg(acos(max(-1, min(1, $dot / $mag))));
    }

    public static function speed(array $velocity): float
    {
        return self::magnitude($velocity);
    }
}
