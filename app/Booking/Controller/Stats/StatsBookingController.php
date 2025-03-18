<?php

declare(strict_types=1);

namespace App\Booking\Controller\Stats;

use App\Booking\Exception\MissingFieldException;
use SFL\Booking\ProfitStat\Application\Query\Dto\BookingDto;
use SFL\Booking\ProfitStat\Application\Query\GetCalculatedProfitStats;
use SFL\Shared\Infrastructure\Symfony\Controller\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class StatsBookingController extends ApiController
{
    #[Route(
        path: 'stats',
        name: 'booking.stats',
        methods: ['POST'],
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $this->validateRequest($request);

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

    private function validateRequest(Request $request): void
    {
        $requiredFields = [
            'request_id',
            'check_in',
            'nights',
            'selling_rate',
            'margin'
        ];

        $requestData = $request->request->all();

        foreach ($requestData as $index => $requestObject) {
            foreach ($requiredFields as $field) {
                if (!isset($requestObject[$field])) {
                    throw new MissingFieldException(
                        sprintf('Field "%s" is missing in request object at index %d.', $field, $index)
                    );
                }
            }
        }
    }
}
