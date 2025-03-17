<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

final class WordMother
{
    public static function create(): string
    {
        return PrimitiveMother::word();
    }

    public static function name(): string
    {
        return PrimitiveMother::name();
    }

    public static function different(string $word): string
    {
        return DifferentMother::different(
            [self::class, 'create'],
            $word
        );
    }

    /**
     * @return list<string>
     */
    public static function multiple(int $from, int $to): array
    {
        return NStubMother::generateBetween(
            static fn(): string => WordMother::create(),
            $from,
            $to
        );
    }
}
