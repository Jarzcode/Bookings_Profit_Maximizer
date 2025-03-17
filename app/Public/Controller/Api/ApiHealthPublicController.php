<?php

declare(strict_types=1);

namespace App\Public\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use SFL\Shared\Infrastructure\Symfony\Controller\ApiController;

final class ApiHealthPublicController extends ApiController
{
    #[Route(
        path: 'health',
        name: 'health.check',
        methods: ['GET'],
    )]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(["health" => "ok"]);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
