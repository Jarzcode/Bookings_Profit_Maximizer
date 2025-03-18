<?php

declare(strict_types=1);

namespace Tests\Double\Booking\Domain\Booking;

use SFL\Booking\ProfitStat\Domain\Booking\Booking;
use SFL\Booking\ProfitStat\Domain\Booking\CheckInDate;
use SFL\Booking\ProfitStat\Domain\Booking\Margin;
use SFL\Booking\ProfitStat\Domain\Booking\Nights;
use SFL\Booking\ProfitStat\Domain\Booking\RequestId;
use SFL\Booking\ProfitStat\Domain\Booking\SellingRate;

final class BookingMother
{
    public static function create(
        ?RequestId $requestId = null,
        ?CheckInDate $checkIn = null,
        ?Nights $nights = null,
        ?SellingRate $sellingRate = null,
        ?Margin $margin = null
    ): Booking {
        return Booking::create(
            requestId: $requestId ?? RequestIdMother::create(),
            checkIn: $checkIn ?? CheckInDateMother::create(),
            nights: $nights ?? NightsMother::create(),
            sellingRate: $sellingRate ?? SellingRateMother::create(),
            margin: $margin ?? MarginMother::create(),
        );
    }
}
