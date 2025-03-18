<?php

declare(strict_types=1);

namespace Tests\Double\Booking\ProfitStat\Domain\Booking;

use SFL\Booking\ProfitStat\Domain\Booking\RequestId;
use Tests\Double\Shared\UuidMother;

final class RequestIdMother
{
    public static function create(?string $value = null): RequestId
    {
        return new RequestId($value ?? UuidMother::create()->value());
    }
}
