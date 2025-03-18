<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\Booking;

use SFL\Booking\ProfitStat\Domain\Booking\Nights;
use Tests\Double\Shared\NumberMother;

final class NightsMother
{
    public static function create(?int $nights = null): Nights
    {
        return new Nights($nights ?? NumberMother::between(1, 90));
    }
}