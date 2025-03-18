<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query;

use InvalidArgumentException;
use SFL\Booking\ProfitStat\Application\Factory\BookingFactory;
use SFL\Booking\ProfitStat\Application\Query\Dto\BookingDto;
use SFL\Booking\ProfitStat\Domain\Booking\Booking;
use SFL\Booking\ProfitStat\Domain\Service\MaximizedProfitStatsCalculator;
use SFL\Shared\Domain\Bus\Query\QueryHandler;

final class GetMaximizedProfitStatsHandler implements QueryHandler
{
    public function __construct(
        private readonly MaximizedProfitStatsViewAssembler $assembler,
        private readonly MaximizedProfitStatsCalculator $maximizedProfitStatsCalculator
    ) {
    }

    public function __invoke(GetMaximizedProfitStats $query): MaximizedProfitStatsView
    {
        if (empty($query->bookingsList)) {
            //TODO: throw custom exception
            throw new InvalidArgumentException('Bookings list cannot be empty');
        }

        $bookings = array_map(
            static fn(BookingDto $bookingDto): Booking => BookingFactory::invoke($bookingDto),
            $query->bookingsList,
        );

        list($requestIds, $maximizedProfitStats) = $this->maximizedProfitStatsCalculator->invoke($bookings);

        return $this->assembler->invoke($requestIds, $maximizedProfitStats);
    }
}
