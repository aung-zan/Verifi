<?php

namespace App\Scramble\Extensions;

use Dedoc\Scramble\Extensions\OperationExtension;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\Generator\Response;
use Dedoc\Scramble\Support\Generator\Schema;
use Dedoc\Scramble\Support\Generator\Types\ArrayType;
use Dedoc\Scramble\Support\Generator\Types\BooleanType;
use Dedoc\Scramble\Support\Generator\Types\ObjectType;
use Dedoc\Scramble\Support\Generator\Types\StringType;
use Dedoc\Scramble\Support\RouteInfo;

class ValidationFailedRespond extends OperationExtension
{
    public function handle(Operation $operation, RouteInfo $routeInfo)
    {
        if ($operation->method === 'post' || $operation->method === 'put') {
            $responseSchema = $this->createResponseSchema();

            $operation->addResponse(
                Response::make(422)
                    ->description('Unprocessable Content')
                    ->setContent(
                        'application/json',
                        $responseSchema
                    )
            );
        }
    }

    private function createResponseSchema(): Schema
    {
        $response = new ObjectType();

        $successProperty = (new BooleanType())->example(false);
        $messageProperty = (new StringType())->example('Validation failed.');

        $validationProperty = new ArrayType();
        $validationMessage = new ObjectType();

        $errorField = (new StringType())->example('email');
        $messageField = (new StringType())->example('The email field is required.');

        $validationMessage->addProperty('field', $errorField);
        $validationMessage->addProperty('message', $messageField);
        $validationMessage->setRequired(['field', 'message']);

        $validationProperty->setItems($validationMessage);

        $response->addProperty('success', $successProperty);
        $response->addProperty('message', $messageProperty);
        $response->addProperty('errors', $validationProperty);
        $response->setRequired(['success', 'message', 'errors']);

        return Schema::fromType($response);
    }
}
