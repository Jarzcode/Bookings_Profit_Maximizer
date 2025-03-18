<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\Booking;

use DateTimeImmutable;
use SFL\Booking\ProfitStat\Domain\Booking\CheckInDate;

final class CheckInDateMother
{
    public static function create(?DateTimeImmutable $dateTimeImmutable = null): CheckInDate
    {
        return new CheckInDate($dateTimeImmutable ?? new DateTimeImmutable());
    }
}
