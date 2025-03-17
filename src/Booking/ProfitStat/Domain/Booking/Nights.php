<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Booking;

use InvalidArgumentException;
use SFL\Shared\Domain\ValueObject\IntValueObject;

final class Nights extends IntValueObject
{
    const MAX_LIMIT_NIGHTS = 100;

    private function __construct(int $value)
    {
        $this->ensureIsPositive($value);
        $this->ensureIsWithinLimit($value);
        $this->value = $value;

        parent::__construct($value);
    }

    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    private function ensureIsPositive(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("Number of nights must be positive");
        }
    }

    private function ensureIsWithinLimit(int $value): void
    {
        if ($value > self::MAX_LIMIT_NIGHTS) {
            throw new InvalidArgumentException("Number of nights cannot exceed 30");
        }
    }
}
