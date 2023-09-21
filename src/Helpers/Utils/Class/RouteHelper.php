<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Class;

use Illuminate\Support\Facades\Route;


/**
 * Class ***`RouteHelper`***
 *
 * This class provides a utility method to force a JSON response format for the given content.
 *
 * It ensures that the response follows a specified schema, even if the content is not already in JsonResponse format.
 * It can be used to ensure consistent JSON output for API responses,
 * even when the provided content is not already in JsonResponse format.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Class`***
 */
class RouteHelper
{
    public static function loadApiRoutesFromVersions($path)
    {
        // Get a list of subdirectories in the provided path (API versions)
        $apiVersions = array_filter(glob($path . '/*'), 'is_dir');

        // Include route files for each API version and group them by version
        foreach ($apiVersions as $version) {
            $versionName = basename($version);


            Route::group(['middleware' => [\LaravelCoreModule\CoreModuleMaker\Middleware\ForceJsonResponseMiddleware::class, \LaravelCoreModule\CoreModuleMaker\Middleware\CORSMiddleware::class] ], function () use ($versionName, $version) {
                Route::prefix($versionName)->group(function () use ($version) {
                    $routeFiles = glob("{$version}/*.php");
                    foreach ($routeFiles as $routeFile) {
                        include $routeFile;
                    }
                });
            });
        }
    }
}
