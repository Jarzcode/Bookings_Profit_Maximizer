<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Service;

use SFL\Booking\ProfitStat\Domain\Booking\Booking;
use SFL\Booking\ProfitStat\Domain\ProfitStat\Average;
use SFL\Booking\ProfitStat\Domain\ProfitStat\MaxProfit;
use SFL\Booking\ProfitStat\Domain\ProfitStat\MinProfit;
use SFL\Booking\ProfitStat\Domain\ProfitStat\ProfitStat;

final class ProfitStatsCalculator
{
    /** @param list<Booking> $bookings */
    public function invoke(array $bookings): ProfitStat
    {
        $totalProfit = 0;
        $minProfit = PHP_INT_MAX;
        $maxProfit = 0;

        foreach ($bookings as $booking) {
            $profit = self::calculateProfitPerNight($booking);
            $totalProfit += $profit;
            $minProfit = min($minProfit, $profit);
            $maxProfit = max($maxProfit, $profit);
        }

        $average = Average::fromFloat($totalProfit / count($bookings));
        $minProfit = MinProfit::fromFloat($minProfit);
        $maxProfit = MaxProfit::fromFloat($maxProfit);

        return new ProfitStat($average, $minProfit, $maxProfit);
    }

    /**
     * @param Booking $booking
     * @return float|int
     */
    public static function calculateProfitPerNight(Booking $booking): int|float
    {
        return ($booking->sellingRate()->value() * ($booking->margin()->value() / 100)) / $booking->nights()->value();
    }
}
