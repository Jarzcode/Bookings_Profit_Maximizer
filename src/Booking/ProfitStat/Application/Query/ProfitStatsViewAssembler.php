<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query;

use SFL\Booking\ProfitStat\Domain\ProfitStat\ProfitStat;
use SFL\Shared\Application\Query\ViewAssembler;

final class ProfitStatsViewAssembler implements ViewAssembler
{
    public function invoke(ProfitStat $profitStats): ProfitStatsView
    {
        return new ProfitStatsView(
            avg_night: $profitStats->average()->value(),
            min_night: $profitStats->minProfit()->value(),
            max_night: $profitStats->maxProfit()->value(),
        );
    }
}
