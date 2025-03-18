<?php

declare(strict_types=1);

namespace App\Booking\Controller\Stats;

use App\Booking\Exception\MissingFieldException;
use SFL\Booking\ProfitStat\Application\Query\Dto\BookingDto;
use SFL\Booking\ProfitStat\Application\Query\Calculate\GetCalculatedProfitStats;
use SFL\Shared\Infrastructure\Symfony\Controller\ApiController;
use SFL\Shared\Infrastructure\Symfony\Controller\ThirdPartiesRequestValidationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class StatsBookingController extends ApiController
{
    use ThirdPartiesRequestValidationTrait;

    #[Route(
        path: 'stats',
        name: 'booking.stats',
        methods: ['POST'],
    )]
    public function __invoke(Request $request): JsonResponse
    {
        self::validateHasAllMandatoryFields($request);

        $statsView = $this->ask(
            new GetCalculatedProfitStats(
                $this->requestDataToDtosList($request),
            )
        );

        return new JsonResponse($statsView);
    }

    protected function exceptions(): array
    {
        return [MissingFieldException::class => 400];
    }

    /**  @return BookingDto[] */
    private function requestDataToDtosList(Request $request): array
    {
        return array_map(
            static fn(array $bookingData): BookingDto => BookingDto::fromArray($bookingData),
            $request->toArray(),
        );
    }
}
