<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query\Maximize;

use SFL\Booking\ProfitStat\Application\Query\Calculate\ProfitStatsViewAssembler;
use SFL\Booking\ProfitStat\Domain\Booking\RequestId;
use SFL\Booking\ProfitStat\Domain\ProfitStat\ProfitStat;

final class MaximizedProfitStatsViewAssembler
{
    public function __construct(private readonly ProfitStatsViewAssembler $profitStatsViewAssembler)
    {
    }

    /** @param RequestId $requestIds */
    public function invoke(array $requestIds, ProfitStat $profitStat): MaximizedProfitStatsView
    {
        return new MaximizedProfitStatsView(
            requestIds: array_map(
                static fn(RequestId $requestId): string => $requestId->value(),
                $requestIds,
            ),
            profitStatsView: $this->profitStatsViewAssembler->invoke($profitStat),
        );
    }
}
