<?php

declare(strict_types=1);

namespace Tests\Double\Shared;

use function Lambdish\Phunctional\repeat;

final class NStubMother
{
    public const DEFAULT_MAX_AMOUNT = 10;

    /**
     * @template T
     * @param callable():T $generator
     * @return list<T>
     */
    public static function generate(callable $generator, int $maxAmount = self::DEFAULT_MAX_AMOUNT): array
    {
        return self::generateBetween($generator, 0, $maxAmount);
    }

    /**
     * @template T
     * @param callable():T $generator
     * @return list<T>
     */
    public static function generateAtLeastOne(callable $generator, int $maxAmount = self::DEFAULT_MAX_AMOUNT): array
    {
        return self::generateAtLeast($generator, 1, $maxAmount);
    }

    /**
     * @template T
     * @param callable():T $generator
     * @return list<T>
     */
    public static function generateAtLeast(
        callable $generator,
        int $minAmount,
        int $maxAmount = self::DEFAULT_MAX_AMOUNT,
    ): array {
        return self::generateBetween($generator, $minAmount, $maxAmount);
    }

    /**
     * @template R
     * @param callable():R $generator
     * @return list<R>
     */
    public static function generateBetween(
        callable $generator,
        int $minAmount,
        int $maxAmount = self::DEFAULT_MAX_AMOUNT,
    ): array {
        return self::generateExactly($generator, NumberMother::between($minAmount, $maxAmount));
    }

    /**
     * @template T
     * @param callable():T $generator
     * @return list<T>
     */
    public static function generateExactly(
        callable $generator,
        int $amount,
    ): array {
        return repeat($generator, $amount);
    }
}
