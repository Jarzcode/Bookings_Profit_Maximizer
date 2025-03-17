<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query;

use SFL\Shared\Application\Query\View;

final class ProfitStatsView implements View
{
    public function __construct(
        public float $avg_night,
        public int $min_night,
        public int $max_night,
    ) {
    }
}
