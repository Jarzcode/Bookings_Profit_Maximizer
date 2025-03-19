<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query\Maximize;

use SFL\Booking\ProfitStat\Application\Query\Calculate\ProfitStatsView;
use SFL\Shared\Application\Query\View;

final class MaximizedProfitStatsView implements View
{
    /** @param list<string> $requestIds */
    public function __construct(
        public array $requestIds,
        public ?float $totalProfit,
        public float $avg_night,
        public float $min_night,
        public float $max_night,
    ) {
    }
}
