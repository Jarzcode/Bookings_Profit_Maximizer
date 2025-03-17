<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

use SFL\Shared\Domain\Uuid;

final class UuidMother
{
    public static function create(): Uuid
    {
        return PrimitiveMother::uuid();
    }
}
