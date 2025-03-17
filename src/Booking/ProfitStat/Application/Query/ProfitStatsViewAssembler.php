<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query;

use SFL\Shared\Application\Query\ViewAssembler;

final class ProfitStatsViewAssembler implements ViewAssembler
{
    public function invoke(ProfitStats $profitStats): ProfitStatsView
    {
        return new ProfitStatsView(
            avg_night: $profitStats->avgNight,
            min_night: $profitStats->minNight,
            max_night: $profitStats->maxNight,
        );
    }
}
