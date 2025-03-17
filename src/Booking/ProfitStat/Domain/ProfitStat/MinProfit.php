<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\ProfitStat;

use InvalidArgumentException;
use SFL\Shared\Domain\ValueObject\FloatValueObject;

final class MinProfit extends FloatValueObject
{
    public function __construct(float $value)
    {
        $this->ensureIsPositive($value);
        parent::__construct($value);
    }

    public static function fromFloat(float $value): self
    {
        return new self($value);
    }

    private function ensureIsPositive(float $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException("MinProfit must be positive");
        }
    }
}
