<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\ProfitStat;

use SFL\Booking\ProfitStat\Domain\ProfitStat\TotalProfit;

final class TotalProfitMother
{
    public static function create(?float $value = null): TotalProfit
    {
        return new TotalProfit($value ?? 10.0);
    }
}
