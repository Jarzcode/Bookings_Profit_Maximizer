<?php

declare(strict_types=1);

namespace Tests\Unit\Booking\ProfitStat\Application\Query\Maximize;

use InvalidArgumentException;
use SFL\Booking\ProfitStat\Application\Query\Maximize\GetMaximizedProfitStats;
use SFL\Booking\ProfitStat\Application\Query\Maximize\GetMaximizedProfitStatsHandler;
use SFL\Booking\ProfitStat\Application\Query\Maximize\MaximizedProfitStatsView;
use SFL\Booking\ProfitStat\Application\Query\Maximize\MaximizedProfitStatsViewAssembler;
use SFL\Booking\ProfitStat\Domain\Service\MaximizedProfitStatsCalculator;
use Tests\Double\Booking\ProfitStat\Application\Query\Dto\BookingDtoMother;
use Tests\Double\Booking\ProfitStat\Domain\Booking\RequestIdMother;
use Tests\Double\Booking\ProfitStat\Domain\ProfitStat\ProfitStatMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class GetMaximizedProfitStatsHandlerTest extends UnitTestCase
{
    private GetMaximizedProfitStatsHandler $handler;
    private MaximizedProfitStatsCalculator $profitStatsCalculator;
    public function setUp(): void
    {
        $this->profitStatsCalculator = $this->createMock(MaximizedProfitStatsCalculator::class);
        $this->handler = new GetMaximizedProfitStatsHandler(
            assembler: new MaximizedProfitStatsViewAssembler(),
            maximizedProfitStatsCalculator: $this->profitStatsCalculator,
        );
        parent::setUp();
    }

    public function test_should_throw_an_exception_if_bookings_list_is_empty(): void
    {
        $query = new GetMaximizedProfitStats([]);

        $this->expectException(InvalidArgumentException::class);

        $this->handler->__invoke($query);
    }

    public function test_should_return_view(): void
    {
        $query = new GetMaximizedProfitStats(
            [
                BookingDtoMother::create(),
                BookingDtoMother::create(),
            ]
        );

        $this->profitStatsCalculator->expects($this->once())
            ->method('invoke')
            ->willReturn(
                [
                    [RequestIdMother::create(), RequestIdMother::create()],
                    ProfitStatMother::create(),
                ]
            );

        $response = $this->handler->__invoke($query);

        $this->assertInstanceOf(MaximizedProfitStatsView::class, $response);
    }
}
