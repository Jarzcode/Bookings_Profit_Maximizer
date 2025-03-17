<?php

declare(strict_types=1);

namespace SFL\Shared\Domain\ValueObject;

use DateTimeImmutable;

abstract class DateTimeValueObject
{
    public function __construct(protected DateTimeImmutable $value)
    {
    }

    final public function value(): DateTimeImmutable
    {
        return $this->value;
    }
}
