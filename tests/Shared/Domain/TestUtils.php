<?php

declare(strict_types=1);

namespace Tests\Shared\Domain;

use Tests\Shared\Infrastructure\Mockery\MyCompanyMatcherIsSimilar;
use Tests\Shared\Infrastructure\PhpUnit\Constraint\MyCompanyConstraintIsSimilar;

final class TestUtils
{
    public static function isSimilar(mixed $expected, mixed $actual): bool
    {
        $constraint = new MyCompanyConstraintIsSimilar($expected);

        return $constraint->evaluate($actual, '', true);
    }

    public static function assertSimilar(mixed $expected, mixed $actual): void
    {
        $constraint = new MyCompanyConstraintIsSimilar($expected);

        $constraint->evaluate($actual);
    }

    public static function similarTo(mixed $value, float $delta = 0.0): MyCompanyMatcherIsSimilar
    {
        return new MyCompanyMatcherIsSimilar($value, $delta);
    }
}
