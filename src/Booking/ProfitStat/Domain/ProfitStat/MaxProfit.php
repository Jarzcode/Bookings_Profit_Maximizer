<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\ProfitStat;

use SFL\Shared\Domain\ValueObject\FloatValueObject;

final class MaxProfit extends FloatValueObject
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
}
