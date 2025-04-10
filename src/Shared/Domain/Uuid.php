<?php

declare(strict_types=1);

namespace SFL\Shared\Domain;

use SFL\Shared\Domain\ValueObject\UuidValueObject;

final class Uuid extends UuidValueObject
{
    public static function create(string $id): self
    {
        return new self($id);
    }
}
