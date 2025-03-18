<?php

declare(strict_types=1);

namespace Tests\Unit\Booking\ProfitStat\Application\Query;

use InvalidArgumentException;
use SFL\Booking\ProfitStat\Application\Query\GetCalculatedProfitStats;
use SFL\Booking\ProfitStat\Application\Query\GetCalculatedProfitStatsHandler;
use SFL\Booking\ProfitStat\Application\Query\ProfitStatsView;
use SFL\Booking\ProfitStat\Application\Query\ProfitStatsViewAssembler;
use SFL\Booking\ProfitStat\Domain\Service\ProfitStatsCalculator;
use Tests\Double\Booking\ProfitStat\Application\Query\Dto\BookingDtoMother;
use Tests\Double\Booking\ProfitStat\Domain\ProfitStat\ProfitStatMother;
use Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

final class GetCalculatedProfitStatsHandlerTest extends UnitTestCase
{
    private GetCalculatedProfitStatsHandler $handler;
    private ProfitStatsCalculator $profitStatsCalculator;
    public function setUp(): void
    {
        $this->profitStatsCalculator = $this->createMock(ProfitStatsCalculator::class);
        $this->handler = new GetCalculatedProfitStatsHandler(
            assembler: new ProfitStatsViewAssembler(),
            profitStatsCalculator: $this->profitStatsCalculator,
        );
        parent::setUp();
    }

    public function test_should_throw_an_exception_if_bookings_list_is_empty(): void
    {
        $query = new GetCalculatedProfitStats([]);

        $this->expectException(InvalidArgumentException::class);

        $this->handler->__invoke($query);
    }

    public function test_should_return_view(): void
    {
        $query = new GetCalculatedProfitStats(
            [
                BookingDtoMother::create(),
                BookingDtoMother::create(),
            ]
        );

        $this->profitStatsCalculator->expects($this->once())
            ->method('invoke')
            ->willReturn(ProfitStatMother::create());

        $response = $this->handler->__invoke($query);

        $this->assertInstanceOf(ProfitStatsView::class, $response);
    }
}
