<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query;

use SFL\Shared\Domain\Bus\Query\Query;

final class GetCalculatedProfitStats implements Query
{
    /** @param list<array{
     *     request_id: string,
     *     check_in: string,
     *     nights: int,
     *     selling_rate: int,
     *     margin: int
     * }> $bookingsList
     */
    public function __construct(public array $bookingsList)
    {
    }
}
