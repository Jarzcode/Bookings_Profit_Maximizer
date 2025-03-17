<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Booking;

use DateTimeImmutable;
use InvalidArgumentException;
use SFL\Shared\Domain\ValueObject\DateTimeValueObject;

final class CheckInDate extends DateTimeValueObject
{
    private function __construct(DateTimeImmutable $value)
    {
        $this->ensureIsNotPast($value);
        $this->value = $value;

        parent::__construct($value);
    }

    public static function fromDateTime(DateTimeImmutable $value): self
    {
        return new self($value);
    }

    public static function fromString(string $checkIn): self
    {
        return new self(new DateTimeImmutable($checkIn));
    }

    private function ensureIsNotPast(DateTimeImmutable $value): void
    {
        if ($value < new DateTimeImmutable('today')) {
            throw new InvalidArgumentException("Check-in date cannot be in the past");
        }
    }
}
