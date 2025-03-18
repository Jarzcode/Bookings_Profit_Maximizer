<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query\Maximize;

use SFL\Booking\ProfitStat\Application\Query\Dto\BookingDto;
use SFL\Shared\Domain\Bus\Query\QueryHandler;

final class GetMaximizedProfitStats implements QueryHandler
{
    /** @param BookingDto $bookingsList */
    public function __construct(public array $bookingsList)
    {
    }
}
