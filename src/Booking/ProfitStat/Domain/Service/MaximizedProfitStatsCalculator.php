<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Service;

use SFL\Booking\ProfitStat\Domain\Booking\Booking;
use SFL\Booking\ProfitStat\Domain\ProfitStat\Average;
use SFL\Booking\ProfitStat\Domain\ProfitStat\MaxProfit;
use SFL\Booking\ProfitStat\Domain\ProfitStat\MinProfit;
use SFL\Booking\ProfitStat\Domain\ProfitStat\ProfitStat;

class MaximizedProfitStatsCalculator
{
    /** @param list<Booking> $bookings */
    public function invoke(array $bookings): array
    {
        //TODO: Calculate the maximized profit stats
        return [
            'requestIds' => [],
            'maximizedProfitStats' => ProfitStat::create(
                Average::fromFloat(1),
                MinProfit::fromFloat(1),
                MaxProfit::fromFloat(1),
            ),
        ];
    }
}
