<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Middleware;

use Closure;
use LaravelCoreModule\CoreModuleMaker\Exceptions\ApplicationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class `CORSMiddleware`
 *
 * This middleware class handles Cross-Origin Resource Sharing (`CORS`) for incoming requests.
 * CORS allows restricted resources on a web page to be requested from another domain outside the domain from which the resource originated.
 * It allows or restricts `cross-origin` requests based on the configuration.
 *
 * @package \LaravelCoreModule\CoreModuleMaker\Configs\Middleware
 */
class CORSMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\JsonResponse)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $allowedOrigins = ['http://localhost'];

        // Validate headers
        $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];
        $allowedHeaders = ['X-Requested-With', 'Content-Type', 'X-Token-Auth', 'Authorization'];

        // Perform header validation
        $requiredHeaders = [
            'Access-Control-Allow-Origin',
            'Access-Control-Allow-Methods',
            'Access-Control-Allow-Credentials',
            'Access-Control-Max-Age',
            'Access-Control-Allow-Headers',
        ];

        // Perform header value validation
        $allowedOrigins = ['http://localhost', 'http://127.0.0.1'];
        $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'];
        $allowedHeaders = ['X-Requested-With', 'Content-Type', 'X-Token-Auth', 'Authorization'];

        // Validate the Origin header
        $origin = $request->header('Origin');

        // Validate the request method
        $requestMethod = $request->method();

        /* foreach ($requiredHeaders as $header) {
            if (!$request->hasHeader($header)) {
                // Return a CORS error response
                throw new ApplicationException(message: "Missing required header: . {$header}", status_code: Response::HTTP_BAD_REQUEST);
            }
        }

        if (!in_array($origin, $allowedOrigins)) {
            // Return a CORS error response
            throw new ApplicationException(message: "Unauthorized origin", status_code: Response::HTTP_UNAUTHORIZED);
        }

        if (!in_array($requestMethod, $allowedMethods)) {
            // Return a CORS error response
            throw new ApplicationException(message: "Unauthorized Method", status_code: Response::HTTP_UNAUTHORIZED);
        }

        $requestHeaders = $request->header('Access-Control-Allow-Headers');

        if ($requestHeaders) {
            $headers = array_map('trim', explode(',', $requestHeaders));
            $invalidHeaders = array_diff($headers, $allowedHeaders);

            if (count($invalidHeaders) > 0) {
                throw new ApplicationException(message: "Unauthorized Allow Headers: " . implode(', ', $invalidHeaders), status_code: Response::HTTP_UNAUTHORIZED);
            }
        } */

        // Proceed with the next middleware if header values pass validation
        return $next($request)
            ->header('Access-Control-Allow-Origin', $origin)
            ->header('Access-Control-Allow-Methods', implode(', ', $allowedMethods))
            ->header('Access-Control-Allow-Credentials', true)
            ->header('Access-Control-Max-Age', '86400')
            ->header('Access-Control-Allow-Headers', implode(', ', $allowedHeaders));
    }
}
