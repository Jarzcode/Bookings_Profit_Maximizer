<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query;

class MaximizedProfitStatsView
{
    /** @param list<string> $requestIds */
    public function __construct(
        public array $requestIds,
        public ProfitStatsView $profitStatsView,
    ) {
    }
}
