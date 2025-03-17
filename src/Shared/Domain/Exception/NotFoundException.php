<?php

declare(strict_types=1);

namespace SFL\Shared\Domain\Exception;

abstract class NotFoundException extends MyCompanyException
{
    protected static function notFoundMessage(string $searched, ?string $criteria = null): string
    {
        return ($criteria)
            ? "<$searched> not found when searching by criteria <$criteria>"
            : "<$searched> not found";
    }
}
