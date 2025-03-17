<?php

declare(strict_types=1);

namespace App\Booking\Exception;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class MissingFieldException extends BadRequestException
{
    public function __construct(string $field)
    {
        parent::__construct(sprintf('Error! Field %s is mandatory', $field));
    }
}
