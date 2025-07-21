<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\Authenticate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'jwt-auth' => Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $th, Request $request) {
            if ($request->is('api/*')) {
                $statusCode = (int) $th->getCode();

                if (
                    $th instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
                    && str_contains($th->getMessage(), 'No query results for model')
                ) {
                    return response()->json([
                        'success' => false,
                        'message' => 'The requested id not found.',
                    ], 404);
                }

                /**
                 * Unauthorized action.
                 */
                if ($th instanceof UnauthorizedHttpException) {
                    return response()->json([
                        'sucess' => false,
                        'message' => $th->getMessage() . '.',
                    ], 401);
                }

                /**
                 * @response JsonResponse([
                 *  'success' => false,
                 *  'message' => 'This action is unauthorized. Please add the api key in the profile.',
                 * ])
                 */
                if ($th instanceof AccessDeniedHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => $th->getMessage() . ' Please add the api key in the profile.',
                    ], 403);
                }

                \Log::info($statusCode);
                \Log::info($th);

                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong.',
                ], $statusCode == 0 ? 500 : $statusCode);
            }
        });
    })->create();
