<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\ProfitStat;

use SFL\Shared\Domain\Aggregate\AggregateRoot;

final class ProfitStat extends AggregateRoot
{
    public function __construct(
        private readonly Average $average,
        private readonly MinProfit $minProfit,
        private readonly MaxProfit $maxProfit,
    ) {
    }

    public static function create(
        Average $average,
        MinProfit $minProfit,
        MaxProfit $maxProfit
    ): self {
        return new self(
            $average,
            $minProfit,
            $maxProfit
        );
    }

    public function average(): Average
    {
        return $this->average;
    }

    public function minProfit(): MinProfit
    {
        return $this->minProfit;
    }

    public function maxProfit(): MaxProfit
    {
        return $this->maxProfit;
    }
}
