<?php

declare(strict_types=1);

namespace SFL\Shared\Domain\Exception;

use SFL\Shared\Domain\ValueObject\EmailAddress;

final class UnexpectedEmailAddress extends UnexpectedValueException
{
    public static function create(string $emailAddress): self
    {
        return new self(
            self::invalidFormatMessage(EmailAddress::class, "Found <$emailAddress>"),
            'email_address.invalid_format',
        );
    }
}
