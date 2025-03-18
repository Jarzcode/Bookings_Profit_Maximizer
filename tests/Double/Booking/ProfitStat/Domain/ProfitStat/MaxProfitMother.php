<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\ProfitStat;

use SFL\Booking\ProfitStat\Domain\ProfitStat\MaxProfit;

final class MaxProfitMother
{
    public static function create(?float $value = null): MaxProfit
    {
        return new MaxProfit($value ?? 1.0);
    }
}
