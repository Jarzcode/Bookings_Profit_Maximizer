<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

use Faker\Factory;
use Faker\Generator;
use Ramsey\Uuid\Uuid as RamseyUuid;
use SFL\Shared\Domain\Uuid;

final class PrimitiveMother
{
    public const DEFAULT_LOCALE = 'es_ES';

    private static ?Generator $faker = null;

    public static function word(): string
    {
        /** @var string */
        return self::create()->word();
    }

    public static function name(): string
    {
        /** @var string */
        return self::create()->name();
    }

    public static function password(int $minLength, int $maxLength): string
    {
        /** @var string */
        return self::create()->password($minLength, $maxLength);
    }

    public static function email(): string
    {
        /** @var string */
        return self::create()->email();
    }

    public static function boolean(): bool
    {
        /** @var bool */
        return self::create()->boolean();
    }

    public static function uuid(): Uuid
    {
        return Uuid::create(RamseyUuid::uuid4()->toString());
    }

    public static function between(int $min, int $max): int
    {
        return self::create()->numberBetween($min, $max);
    }

    private static function create(): Generator
    {
        return self::$faker = self::$faker ?? Factory::create(self::DEFAULT_LOCALE);
    }
}
