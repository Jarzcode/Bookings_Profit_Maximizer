<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Application\Query\Dto;

final class BookingDto
{
    private function __construct(
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
            $data['request_id'],
            $data['check_in'],
            $data['nights'],
            $data['selling_rate'],
            $data['margin']
        );
    }
}
