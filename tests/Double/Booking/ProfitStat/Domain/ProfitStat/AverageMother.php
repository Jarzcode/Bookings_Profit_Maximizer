<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\ProfitStat;

use SFL\Booking\ProfitStat\Domain\ProfitStat\Average;

final class AverageMother
{
    public static function create(?float $value = null): Average
    {
        return new Average($value ?? 1.0);
    }
}
