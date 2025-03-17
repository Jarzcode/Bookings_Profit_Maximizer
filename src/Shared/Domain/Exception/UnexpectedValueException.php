<?php

declare(strict_types=1);

namespace SFL\Shared\Domain\Exception;

/**
 * These exceptions are interpreted as client errors.
 * By default, are mapped to 400 HTTP status code, but it can be overwritten on controllers.
 */
abstract class UnexpectedValueException extends MyCompanyException
{
    protected static function invalidFormatMessage(string $entityName, string $message = 'Unknown error'): string
    {
        return "Not a valid <$entityName>. Message: $message";
    }
}
