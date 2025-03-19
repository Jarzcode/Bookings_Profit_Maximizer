<?php

declare(strict_types=1);

namespace Tests\Unit\Booking\ProfitStat\Domain\Service;

use DateTimeImmutable;
use SFL\Booking\ProfitStat\Domain\ProfitStat\ProfitStat;
use SFL\Booking\ProfitStat\Domain\Service\HighestProfitGraphPathFinder;
use SFL\Booking\ProfitStat\Domain\Service\MaximizedProfitStatsCalculator;
use Tests\Double\Booking\ProfitStat\Domain\Booking\BookingMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\CheckInDateMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\MarginMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\NightsMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\RequestIdMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\SellingRateMother;
use Tests\Double\Booking\ProfitStat\Domain\ProfitStat\AverageMother;
use Tests\Double\Booking\ProfitStat\Domain\ProfitStat\MaxProfitMother;
use Tests\Double\Booking\ProfitStat\Domain\ProfitStat\MinProfitMother;
use Tests\Double\Booking\ProfitStat\Domain\ProfitStat\TotalProfitMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class MaximizedProfitStatsCalculatorTest extends UnitTestCase
{
    private MaximizedProfitStatsCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new MaximizedProfitStatsCalculator(
            new HighestProfitGraphPathFinder(),
        );
    }

    /** @dataProvider bookingsDataProvider */
    public function test_it_should_calculate_the_best_profit(array $bookings, array $expected): void
    {
        $result = $this->calculator->invoke($bookings);

        $this->assertIsArray($result);
        $this->assertIsArray($result[0]);
        $this->assertInstanceOf(ProfitStat::class, $result[1]);

        $this->assertEquals($expected['requestIds'], $result[0]);
        $this->assertEquals($expected['profitStat'], $result[1]);
    }

    public function bookingsDataProvider(): array
    {
        return [
            'three bookings' => [
                [
                    BookingMother::create(
                        requestId: RequestIdMother::create("A"),
                        checkIn: CheckInDateMother::create(new DateTimeImmutable("2030-01-01")),
                        nights: NightsMother::create(10),
                        sellingRate: SellingRateMother::create(1000),
                        margin: MarginMother::create(10),
                    ),
                    BookingMother::create(
                        requestId: RequestIdMother::create("B"),
                        checkIn: CheckInDateMother::create(new DateTimeImmutable("2030-01-06")),
                        nights: NightsMother::create(10),
                        sellingRate: SellingRateMother::create(700),
                        margin: MarginMother::create(10),
                    ),
                    BookingMother::create(
                        requestId: RequestIdMother::create("C"),
                        checkIn: CheckInDateMother::create(new DateTimeImmutable("2030-01-12")),
                        nights: NightsMother::create(10),
                        sellingRate: SellingRateMother::create(400),
                        margin: MarginMother::create(10),
                    ),
                ],
                [
                    'requestIds' => [RequestIdMother::create("A"), RequestIdMother::create("C")],
                    'profitStat' => ProfitStat::create(
                        AverageMother::create(7),
                        MinProfitMother::create(4),
                        MaxProfitMother::create(10),
                        TotalProfitMother::create(140),
                    ),
                ],
            ],
        ];
    }
}
