<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Application\Query\Dto;

use SFL\Booking\ProfitStat\Application\Query\Dto\BookingDto;
use Tests\Double\Booking\ProfitStat\Domain\Booking\CheckInDateMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\MarginMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\NightsMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\RequestIdMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\SellingRateMother;

final class BookingDtoMother
{
    public static function create(): BookingDto
    {
        return new BookingDto(
            requestId: RequestIdMother::create()->value(),
            checkIn: CheckInDateMother::create()->value()->format('Y-m-d'),
            nights: NightsMother::create()->value(),
            sellingRate: SellingRateMother::create()->value(),
            margin: MarginMother::create()->value(),
        );
    }
}
