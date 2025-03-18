<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query\Calculate;

use InvalidArgumentException;
use SFL\Booking\ProfitStat\Application\Factory\BookingFactory;
use SFL\Booking\ProfitStat\Application\Query\Dto\BookingDto;
use SFL\Booking\ProfitStat\Domain\Booking\Booking;
use SFL\Booking\ProfitStat\Domain\Service\ProfitStatsCalculator;
use SFL\Shared\Domain\Bus\Query\QueryHandler;

final class GetCalculatedProfitStatsHandler implements QueryHandler
{
    public function __construct(
        private readonly ProfitStatsViewAssembler $assembler,
        private readonly ProfitStatsCalculator $profitStatsCalculator
    ) {
    }

    public function __invoke(GetCalculatedProfitStats $query): ProfitStatsView
    {
        if (empty($query->bookingsList)) {
            //TODO: throw custom exception
            throw new InvalidArgumentException('Bookings list cannot be empty');
        }

        $bookings = array_map(
            static fn(BookingDto $bookingDto): Booking => BookingFactory::invoke($bookingDto),
            $query->bookingsList,
        );

        $profitStats = $this->profitStatsCalculator->invoke($bookings);

        return $this->assembler->invoke($profitStats);
    }
}
