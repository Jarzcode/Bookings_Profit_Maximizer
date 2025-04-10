<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Booking;

use SFL\Shared\Domain\Aggregate\AggregateRoot;

final class Booking extends AggregateRoot
{
    public function __construct(
        private readonly RequestId $requestId,
        private readonly CheckInDate $checkIn,
        private readonly Nights $nights,
        private readonly SellingRate $sellingRate,
        private readonly Margin $margin
    ) {
    }

    public static function create(
        RequestId $requestId,
        CheckInDate $checkIn,
        Nights $nights,
        SellingRate $sellingRate,
        Margin $margin
    ): self {
        return new self(
            requestId: $requestId,
            checkIn: $checkIn,
            nights: $nights,
            sellingRate: $sellingRate,
            margin: $margin
        );
    }

    public function requestId(): RequestId
    {
        return $this->requestId;
    }

    public function checkIn(): CheckInDate
    {
        return $this->checkIn;
    }

    public function nights(): Nights
    {
        return $this->nights;
    }

    public function sellingRate(): SellingRate
    {
        return $this->sellingRate;
    }

    public function margin(): Margin
    {
        return $this->margin;
    }
}
