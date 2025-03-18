<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\ProfitStat;

use SFL\Booking\ProfitStat\Domain\ProfitStat\MinProfit;

final class MinProfitMother
{
    public static function create(?float $value = null): MinProfit
    {
        return new MinProfit($value ?? 1.0);
    }
}
