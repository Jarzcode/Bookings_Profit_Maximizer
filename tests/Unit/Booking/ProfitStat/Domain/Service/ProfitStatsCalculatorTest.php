<?php

declare(strict_types=1);

namespace Tests\Unit\Booking\ProfitStat\Domain\Service;

use SFL\Booking\ProfitStat\Domain\Booking\Booking;
use SFL\Booking\ProfitStat\Domain\Booking\SellingRate;
use SFL\Booking\ProfitStat\Domain\Service\ProfitStatsCalculator;
use Tests\Double\Booking\Domain\Booking\BookingMother;
use Tests\Double\Booking\Domain\Booking\MarginMother;
use Tests\Double\Booking\Domain\Booking\NightsMother;
use Tests\Double\Booking\Domain\Booking\SellingRateMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class ProfitStatsCalculatorTest extends UnitTestCase
{
    private ProfitStatsCalculator $service;
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProfitStatsCalculator();
    }

    /** @dataProvider wrongDataProvider */
    public function test_should_fail_with_invalid_data(int $nights, int $sellingRate, int $margin): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $bookings = [
            BookingMother::create(
                nights: NightsMother::create($nights),
                sellingRate: SellingRateMother::create($sellingRate),
                margin: MarginMother::create($margin),
            ),
        ];

        $this->service::invoke($bookings);
    }

    public function test_should_calculate_the_profit_stats(): void
    {
        $bookings = [
            BookingMother::create(
                nights: NightsMother::create(5),
                sellingRate: SellingRateMother::create(200),
                margin: MarginMother::create(20),
            ),
            BookingMother::create(
                nights: NightsMother::create(4),
                sellingRate: SellingRateMother::create(156),
                margin: MarginMother::create(22),
            ),
        ];

        $profitStats = $this->service::invoke($bookings);

        $this->assertEquals(8.29, $profitStats->average()->value());
        $this->assertEquals(8, $profitStats->minProfit()->value());
        $this->assertEquals(8.58, $profitStats->maxProfit()->value());
    }

    /** @return array<array<int>> */
    public function wrongDataProvider(): array
    {
        return [
            ['nights' => -10, 'sellingRate' => 20, 'margin' => 10],
            ['nights' => 10, 'sellingRate' => -120, 'margin' => 10],
            ['nights' => 10, 'sellingRate' => 20, 'margin' => -10],
            ['nights' => 10, 'sellingRate' => 20, 'margin' => 101],
            ['nights' => 0, 'sellingRate' => 20, 'margin' => 10],
        ];
    }
}
