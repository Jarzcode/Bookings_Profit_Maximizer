<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Service;

use DateTimeImmutable;
use SFL\Booking\ProfitStat\Domain\Booking\Booking;
use SFL\Booking\ProfitStat\Domain\Booking\RequestId;
use SFL\Booking\ProfitStat\Domain\ProfitStat\Average;
use SFL\Booking\ProfitStat\Domain\ProfitStat\MaxProfit;
use SFL\Booking\ProfitStat\Domain\ProfitStat\MinProfit;
use SFL\Booking\ProfitStat\Domain\ProfitStat\ProfitStat;

class MaximizedProfitStatsCalculator
{
    public function __construct(
        private readonly HighestProfitGraphPathFinder $graphPathFinder
    ) {
    }

    /** @param list<Booking> $bookings */
    public function invoke(array $bookings): array
    {
        // Step 1: Build the graph from the bookings
        $graph = $this->buildGraph($bookings);

        // Step 2: Apply Dijkstra's algorithm (inverse) to find the path with the maximum profit
        list($bestCombination, $totalProfit) = $this->graphPathFinder->invoke($graph);

        return [
            array_map(
                static fn(string $id) => RequestId::fromString($id),
                array_reverse($bestCombination),
            ),
            ProfitStat::create(
                Average::fromFloat((float) $totalProfit),
                MinProfit::fromFloat(1.0),
                MaxProfit::fromFloat(1.0),
            ),
        ];

        // Step 3: Calculate average, min, and max profit per night
        $totalNights = 0;
        $profitsPerNight = [];
        foreach ($bestCombination as $id) {
            $booking = $bookings[$id];
            $nights = $booking['nights'];
            $profit = $this->calculateProfit($booking);
            $profitsPerNight[] = $profit / $nights;
            $totalNights += $nights;
        }

        $avgNight = array_sum($profitsPerNight) / count($profitsPerNight);
        $minNight = min($profitsPerNight);
        $maxNight = max($profitsPerNight);

        // Step 4: Return result
        return [
            'requestIds' => array_reverse($bestCombination),
            'maximizedProfitStats' => ProfitStat::create(Average::fromFloat($avgNight), $minNight, $maxNight),
            'total_profit' => $totalProfit,
            'avg_night' => $avgNight,
            'min_night' => $minNight,
            'max_night' => $maxNight
        ];
    }

    /** @param list<Booking> $bookings */
    private function buildGraph(array $bookings)
    {
        $n = count($bookings);
        $graph = [];

        // Build the graph where the node is a booking, and the edge represents compatibility
        for ($i = 0; $i < $n; $i++) {
            $booking = $bookings[$i];
            $requestIdA = $booking->requestId()->value();
            $graph[] = [];

            $graph[$requestIdA] = [];
            for ($j = 0; $j < $n; $j++) {
                if ($i === $j) {
                    continue;
                }

                $bookingA = $bookings[$i];
                $bookingB = $bookings[$j];
                $requestIdB = $bookingB->requestId()->value();

                $booking1Duration = new DateTimeImmutable(
                    $bookingA->checkIn()->value()->format('Y-m-d') .
                    ' + ' .
                    $bookingA->nights()->value() . ' days'
                );

                if ( $booking1Duration <= $bookingB->checkIn()->value() ) {
                    $graph[$requestIdA][$requestIdB] =
                        $this->calculateProfit($bookingA) + $this->calculateProfit($bookingB);
                }
            }
        }
        return $graph;
    }

    public static function calculateProfit(Booking $booking): int|float
    {
        return ($booking->sellingRate()->value() * ($booking->margin()->value() / 100));
    }
}
