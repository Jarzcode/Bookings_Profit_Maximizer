<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query;

use SFL\Shared\Domain\Bus\Query\QueryHandler;

final class GetCalculatedProfitStatsHandler implements QueryHandler
{
    public function __construct(private readonly ProfitStatsViewAssembler $assembler)
    {
    }

    public function __invoke(GetCalculatedProfitStats $query): ProfitStatsView
    {
        $bookings = array_map(
            static fn(array $bookingData): Booking => Booking::fromArray($bookingData),
            $query->bookingsList,
        );

        $profitStats = $this->profitStatsCalculator($bookings);

        return $this->assembler->invoke($profitStats);
    }
}
