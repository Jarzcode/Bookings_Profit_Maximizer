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
use SFL\Booking\ProfitStat\Domain\ProfitStat\TotalProfit;

/**
 * To achieve the goal of getting the maximum profit between several bookings,
 * I've chosen to use a graph to represent the compatibility between bookings.
 * Every node in the graph is a booking, and the edge represents the compatibility between two bookings.
 *
 * To find the best combination of bookings, I've used the Dijkstra algorithm to find the path with the highest profit.
 */
class MaximizedProfitStatsCalculator
{
    public function __construct(
        private readonly HighestProfitGraphPathFinder $graphPathFinder
    ) {
    }

    /** @param list<Booking> $bookings */
    public function invoke(array $bookings): array
    {
        $graph = $this->buildGraph($bookings);

        list($bestCombination, $totalProfit) = $this->graphPathFinder->invoke($graph);

        return $this->buildStats($bestCombination, $bookings, $totalProfit);
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

    /**
     * @param list<string> $bestCombination
     * @param list<Booking> $bookings
     * @return array{list<RequestId>, ProfitStat}
     */
    public function buildStats(array $bestCombination, array $bookings, float $totalProfit): array
    {
        if (empty($bestCombination)) {
            return [[], ProfitStat::create(
                Average::fromFloat(0),
                MinProfit::fromFloat(0),
                MaxProfit::fromFloat(0),
                TotalProfit::fromFloat(0),
            )];
        }

        $profitsPerNight = [];
        foreach ($bestCombination as $id) {
            $selectedBooking = null;

            /** @var Booking $selectedBooking */
            $selectedBooking = current(
                array_filter(
                    $bookings,
                    fn($booking) => $booking->requestId()->value() === $id
                )
            );

            if ($selectedBooking === false) {
                continue;
            }

            $nights = $selectedBooking->nights()->value();
            $profit = $this->calculateProfit($selectedBooking);
            $profitsPerNight[] = $profit / $nights;
        }

        $avgNight = array_sum($profitsPerNight) / count($profitsPerNight);
        $minNight = min($profitsPerNight);
        $maxNight = max($profitsPerNight);

        return [
            array_map(
                static fn(string $id) => RequestId::fromString($id),
                $bestCombination,
            ),
            ProfitStat::create(
                Average::fromFloat($avgNight),
                MinProfit::fromFloat($minNight),
                MaxProfit::fromFloat($maxNight),
                TotalProfit::fromFloat($totalProfit),
            ),
        ];
    }
}
