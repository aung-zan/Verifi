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

class AuthenticationFailedResponse extends OperationExtension
{
    public function handle(Operation $operation, RouteInfo $routeInfo): void
    {
        $methodName = $routeInfo->methodName();

        if ($methodName !== 'register') {
            $responseSchema = $this->createResponseSchema($methodName);

            $operation->addResponse(
                Response::make(401)
                    ->description('Unauthorized')
                    ->setContent(
                        'application/json',
                        $responseSchema
                    )
            );
        }
    }

    private function createResponseSchema($methodName): Schema
    {
        $examples = $methodName === 'login' ? ['Email or Password is wrong.']
            : ['Token not provided.', 'Token has expired.', 'The token has been blacklisted.'];

        $response = new ObjectType();

        $successProperty = (new BooleanType())->example(false);
        $messageProperty = (new StringType())->examples($examples);

        $response->addProperty('success', $successProperty);
        $response->addProperty('message', $messageProperty);

        $response->setRequired(['success', 'message']);

        return Schema::fromType($response);
    }
}
