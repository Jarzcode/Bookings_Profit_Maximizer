<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query\Maximize;

use SFL\Booking\ProfitStat\Domain\Booking\RequestId;
use SFL\Booking\ProfitStat\Domain\ProfitStat\ProfitStat;

final class MaximizedProfitStatsViewAssembler
{
    /** @param list<RequestId> $requestIds */
    public function invoke(array $requestIds, ProfitStat $profitStat): MaximizedProfitStatsView
    {
        return new MaximizedProfitStatsView(
            requestIds: array_map(
                static fn(RequestId $requestId): string => $requestId->value(),
                $requestIds,
            ),
            totalProfit: $profitStat->totalProfit()->value(),
            avg_night: $profitStat->average()->value(),
            min_night: $profitStat->minProfit()->value(),
            max_night: $profitStat->maxProfit()->value(),
        );
    }
}
