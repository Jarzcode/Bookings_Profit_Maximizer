<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Booking;

use InvalidArgumentException;
use SFL\Shared\Domain\ValueObject\IntValueObject;

final class Margin extends IntValueObject
{
    private function __construct(int $value)
    {
        $this->ensureIsValidPercentage($value);
        $this->value = $value;

        parent::__construct($value);
    }

    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    private function ensureIsValidPercentage(int $value): void
    {
        if ($value < 0 || $value > 100) {
            throw new InvalidArgumentException("Margin must be between 0 and 100");
        }
    }
}
