<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Factory;

use SFL\Booking\ProfitStat\Application\Query\Dto\BookingDto;
use SFL\Booking\ProfitStat\Domain\Booking\Booking;
use SFL\Booking\ProfitStat\Domain\Booking\CheckInDate;
use SFL\Booking\ProfitStat\Domain\Booking\Margin;
use SFL\Booking\ProfitStat\Domain\Booking\Nights;
use SFL\Booking\ProfitStat\Domain\Booking\RequestId;
use SFL\Booking\ProfitStat\Domain\Booking\SellingRate;

final class BookingFactory
{
    public static function invoke(BookingDto $bookingDto): Booking
    {
        return new Booking(
            requestId: RequestId::fromString($bookingDto->requestId),
            checkIn: CheckInDate::fromString($bookingDto->checkIn),
            nights: Nights::fromInt($bookingDto->nights),
            sellingRate: SellingRate::fromInt($bookingDto->sellingRate),
            margin: Margin::fromInt($bookingDto->margin),
        );
    }
}
