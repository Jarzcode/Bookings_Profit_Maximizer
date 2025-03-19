<?php

declare(strict_types=1);

namespace App\Booking\Controller\Maximize;

use App\Booking\Exception\MissingFieldException;
use Exception;
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

        $requestData = json_decode($request->getContent(), true);

        if (empty($requestData)) {
            return new JsonResponse(['error' => 'Request data is empty'], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $maximizedProfitStats = $this->ask(
                new GetMaximizedProfitStats(
                    $this->requestDataToDtosList($request),
                )
            );

            return new JsonResponse($maximizedProfitStats);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function exceptions(): array
    {
        return [MissingFieldException::class => 400];
    }

    /**  @return BookingDto[] */
    private function requestDataToDtosList(Request $request): array
    {
        $requestData = json_decode($request->getContent(), true);

        return array_map(
            static fn(array $bookingData): BookingDto => BookingDto::fromArray($bookingData),
            $requestData,
        );
    }
}
