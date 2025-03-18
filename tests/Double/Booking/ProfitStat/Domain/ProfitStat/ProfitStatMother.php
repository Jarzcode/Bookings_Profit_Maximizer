<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\ProfitStat;

use SFL\Booking\ProfitStat\Domain\ProfitStat\Average;
use SFL\Booking\ProfitStat\Domain\ProfitStat\MaxProfit;
use SFL\Booking\ProfitStat\Domain\ProfitStat\MinProfit;
use SFL\Booking\ProfitStat\Domain\ProfitStat\ProfitStat;

final class ProfitStatMother
{
    public static function create(
        ?Average $average = null,
        ?MinProfit $minProfit = null,
        ?MaxProfit $maxProfit = null
    ): ProfitStat {
        return ProfitStat::create(
            $average ?? AverageMother::create(),
            $minProfit ?? MinProfitMother::create(),
            $maxProfit ?? MaxProfitMother::create()
        );
    }
}
