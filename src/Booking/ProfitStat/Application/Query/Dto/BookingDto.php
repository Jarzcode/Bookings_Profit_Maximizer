<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query\Dto;

final class BookingDto
{
    public function __construct(
        public string $requestId,
        public string $checkIn,
        public int $nights,
        public int $sellingRate,
        public int $margin
    ) {
    }

    /** @param array{
     *     request_id: string,
     *     check_in: string,
     *     nights: int,
     *     selling_rate: int,
     *     margin: int
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            requestId: $data['request_id'],
            checkIn: $data['check_in'],
            nights: $data['nights'],
            sellingRate: $data['selling_rate'],
            margin: $data['margin']
        );
    }
}
