<?php

namespace App\Scramble\Extensions;

use Dedoc\Scramble\Extensions\OperationExtension;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\RouteInfo;

class ModifyOperationResponse extends OperationExtension
{
    public function handle(Operation $operation, RouteInfo $routeInfo)
    {
        $operation->responses = collect($operation->responses)->filter(function ($response) {
            if (isset($response->code)) {
                return $response->code !== 401;
            } else {
                return ! (strpos($response->fullName, 'Authorization') !== false);
            }
        })->values()->all();
    }
}
