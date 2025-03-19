<?php

declare(strict_types=1);

namespace SFL\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class FloatValueObject
{
    public function __construct(protected float $value)
    {
    }

    final public function value(): float
    {
        return $this->value;
    }

    protected function ensureIsPositive(float $value): void
    {
        if ($value < 0) {
            //TODO: Throw a custom exception
            throw new InvalidArgumentException("MaxProfit must be positive");
        }
    }
}
