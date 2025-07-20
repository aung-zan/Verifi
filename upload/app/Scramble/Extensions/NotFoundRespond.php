<?php

namespace App\Scramble\Extensions;

use Dedoc\Scramble\Extensions\OperationExtension;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\Generator\Response;
use Dedoc\Scramble\Support\Generator\Schema;
use Dedoc\Scramble\Support\Generator\Types\BooleanType;
use Dedoc\Scramble\Support\Generator\Types\ObjectType;
use Dedoc\Scramble\Support\Generator\Types\StringType;
use Dedoc\Scramble\Support\RouteInfo;

class NotFoundRespond extends OperationExtension
{
    public function handle(Operation $operation, RouteInfo $routeInfo)
    {
        if (! empty($operation->parameters)) {
            $responseSchema = $this->createResponseSchema();

            $operation->addResponse(
                Response::make(404)
                    ->description('Not Found.')
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
        $messageProperty = (new StringType())->example('The requested id not found.');

        $response->addProperty('success', $successProperty);
        $response->addProperty('message', $messageProperty);

        $response->setRequired(['success', 'message']);

        return Schema::fromType($response);
    }
}
