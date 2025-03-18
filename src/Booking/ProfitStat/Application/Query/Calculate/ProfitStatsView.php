<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query\Calculate;

use SFL\Shared\Application\Query\View;

final class ProfitStatsView implements View
{
    public function __construct(
        public float $avg_night,
        public float $min_night,
        public float $max_night,
    ) {
    }
}
