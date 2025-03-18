<?php

declare(strict_types=1);

namespace SFL\Shared\Infrastructure\Symfony\Controller;

use App\Booking\Exception\MissingFieldException;
use Symfony\Component\HttpFoundation\Request;

trait ThirdPartiesRequestValidationTrait
{
    public static function validateHasAllMandatoryFields(Request $request): void
    {
        $requiredFields = [
            'request_id',
            'check_in',
            'nights',
            'selling_rate',
            'margin'
        ];

        $requestData = $request->request->all();

        //TODO: We could improve it returning all missing fields at once
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