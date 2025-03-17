<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Booking;

use InvalidArgumentException;
use SFL\Shared\Domain\ValueObject\IntValueObject;

final class SellingRate extends IntValueObject
{
    private function __construct(int $value)
    {
        $this->ensureIsPositive($value);
        $this->value = $value;

        parent::__construct($value);
    }

    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    private function ensureIsPositive(int $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException("Selling rate must be positive");
        }
    }
}
