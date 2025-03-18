<?php

declare(strict_types=1);

namespace SFL\Booking\ProfitStat\Domain\Booking;

use InvalidArgumentException;
use SFL\Shared\Domain\ValueObject\StringValueObject;

final class RequestId extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->ensureIsNotEmpty($value);
        $this->value = $value;

        parent::__construct($value);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    private function ensureIsNotEmpty(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException("RequestId cannot be empty");
        }
    }
}
