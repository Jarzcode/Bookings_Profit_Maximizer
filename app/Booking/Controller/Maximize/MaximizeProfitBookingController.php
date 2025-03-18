<?php

declare(strict_types=1);

namespace App\Booking\Controller\Maximize;

use App\Booking\Exception\MissingFieldException;
use SFL\Booking\ProfitStat\Application\Query\Dto\BookingDto;
use SFL\Booking\ProfitStat\Application\Query\Maximize\GetMaximizedProfitStats;
use SFL\Shared\Infrastructure\Symfony\Controller\ApiController;
use SFL\Shared\Infrastructure\Symfony\Controller\ThirdPartiesRequestValidationTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class MaximizeProfitBookingController extends ApiController
{
    use ThirdPartiesRequestValidationTrait;

    #[Route(
        path: 'maximize',
        name: 'booking.maximize',
        methods: ['POST'],
    )]
    public function __invoke(Request $request): JsonResponse
    {
        self::validateHasAllMandatoryFields($request);

        $maximizedProfitStats = $this->ask(
            new GetMaximizedProfitStats(
                $this->requestDataToDtosList($request),
            )
        );

        return new JsonResponse($maximizedProfitStats);
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
