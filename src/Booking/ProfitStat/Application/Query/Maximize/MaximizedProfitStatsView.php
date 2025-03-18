<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query\Maximize;

use SFL\Booking\ProfitStat\Application\Query\Calculate\ProfitStatsView;

class MaximizedProfitStatsView
{
    /** @param list<string> $requestIds */
    public function __construct(
        public array $requestIds,
        public ProfitStatsView $profitStatsView,
    ) {
    }
}
