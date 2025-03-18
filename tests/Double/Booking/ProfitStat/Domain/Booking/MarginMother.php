<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\Booking;

use SFL\Booking\ProfitStat\Domain\Booking\Margin;
use Tests\Double\Shared\NumberMother;

final class MarginMother
{
    public static function create(?int $value = null): Margin
    {
        return new Margin($value ?? NumberMother::create());
    }
}
