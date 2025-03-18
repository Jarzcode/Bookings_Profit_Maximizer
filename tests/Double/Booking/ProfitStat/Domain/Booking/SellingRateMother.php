<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\Booking;

use SFL\Booking\ProfitStat\Domain\Booking\SellingRate;
use Tests\Double\Shared\NumberMother;

final class SellingRateMother
{
    public static function create(?int $value = null): SellingRate
    {
        return new SellingRate($value ?? NumberMother::create());
    }
}
