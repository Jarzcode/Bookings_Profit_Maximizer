<?php

declare(strict_types=1);

namespace Tests\Shared\Infrastructure\Mockery;

use Mockery\Matcher\MatcherInterface;
use Stringable;
use Tests\Shared\Infrastructure\PhpUnit\Constraint\MyCompanyConstraintIsSimilar;

final class MyCompanyMatcherIsSimilar implements Stringable, MatcherInterface
{
    private MyCompanyConstraintIsSimilar $constraint;

    public function __construct(mixed $value, float $delta = 0.0)
    {
        $this->constraint = new MyCompanyConstraintIsSimilar($value, $delta);
    }

    public function match(&$actual): bool
    {
        return $this->constraint->evaluate($actual, '', true);
    }

    public function __toString(): string
    {
        return 'Is similar';
    }
}
