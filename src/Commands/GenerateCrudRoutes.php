<?php

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateCrudRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:resource-routes
                            {name : The name of the resource (singular, lowercase)}
                            {--controller= : Specify the controller name}
                            {--controller-path=app/Http/Controllers/APIs/RESTful/V1}
                            {--actions= : Specify CRUD actions (comma-separated)}
                            {--except-route-methods= : Exclude certain HTTP methods from the generated routes}
                            {--parent-resource= : Specify a parent resource for nested routes. This can be useful for generating nested resource route}
                            {--route-group=api Group the generated routes within a route group. This is useful for applying middleware, prefix, and other group settings}
                            {--namespace-for-controller= : Specify a namespace for the routes}
                            {--only-route-methods= : generate routes only for specific HTTP methods (e.g., GET, POST, PUT, PATCH, DELETE)}
                            {--route-name-prefix= : Specify a prefix for the route names. This can be helpful for namespacing and avoiding conflicts}
                            {--custom-routes-file= : Specify the custom routes file name}
                            {--route-middleware=api,throttle:60 : Specify middleware specific to the generated routes (in addition to any group middleware}
                            {--resource-file-directory= : Specify a custom directory for storing the generated resource files}
                            {--middlewares= : Specify middleware for the routes (comma-separated)}
                            {--api-resource : Generate API resource routes with full CRUD actions. This generates routes for index, store, show, update, and destroy actions}
                            {--subdomain=api : Generate routes with a subdomain prefix. Useful for multi-tenancy or domain-specific routing}
                            {--resource-name= : Specify a custom name for the resource in route URLs. This allows users to customize the route URLs while keeping the resource name unchanged}
                            {--base-route= : }
                            {--generate-controllers : Generate controller classes along with the routes, using a default template or a custom template}
                            {--force-controllers : }
                            {--route-names=api. : }
                            {--no-controller : }
                            {--disable-verbs : }
                            {--api-version=v1 : }
                            {--route-name-suffix=v1 : }
                            {--parent-route-parameter= : }
                            {--language-prefix=en : }
                            {--middleware-group= : }
                            {--namespace-group= : }
                            {--nested= : }
                            {--no-prefix : }
                            {--only-api-routes : }
                            {--only-web : }
                            {--resource-only : }
                            {--sortable : Generate sortable routes, such as for reordering items.}
                            {--searchable : Generate routes for searching/filtering resources.}
                            {--relationships= : Generate routes for resource relationships. This can automatically generate routes for related resource}
                            {--prefix-namespace : Generate routes with a nested namespace based on the parent resource. This can help organize your controllers and routes.}
                            {--parent-namespace= : Specify a namespace for the parent resource when using nested routes}
                            {--resource=search,export : Generate additional resource routes beyond the default CRUD routes, such as search, export, import, etc}
                            {--only-routes : Generate only the route definitions without writing them to a file. Useful for previewing the generated routes before saving}
                            {--format=kebab-case : Specify the route URL format, such as "snake_case," "kebab-case," or "camelCase."}
                            {--prefix= : Specify a URL prefix for the routes}
                            {--versionning=v1 : Specify the version of the routes}
                            {--view : Generate view routes along with resource routes}
                            {--no-api : Skip generating API-specific routes (such as JSON resources) and only generate web routes}
                            {--no-views : Specify to generate routes without the associated view routes}
                            {--force : Force overwrite if routes file exists}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD routes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Prompt user for input (e.g., resource name)
        //$resourceName = $this->ask('Enter the resource name (singular, lowercase):');

        $resourceName = $this->argument('name');
        ///$controllerStub = file_get_contents("./../stubs/controller.stub");
        $templatePath = "./../stubs/routes/resource-routes.stub";///base_path('core/Stubs/Routes/resource-routes.stub'); // Replace with your actual template path
        
        $version = str_replace(['v', 'V'], [''], $this->option('versionning'));

        if (!file_exists("routes/apis/{$this->option('versionning')}")) {
            createCascadeDirectories("routes/apis/{$this->option('versionning')}");
        }

        $outputPath = base_path("routes/apis/{$this->option('versionning')}/" . strtolower($resourceName) . '-routes.php');

        if (!File::exists($templatePath)) {
            $this->error('Template file not found.');
            return;
        }

        $middlewares = $this->option('middlewares');

        if(!is_string($this->option('middlewares')))
        {
            $this->info("\nEnter the middlewares names should be string separate by comma in lowercase");
        }

        if($middlewares)
            $middlewares = implode(',', array_map(
                function($middleware){
                    return "'$middleware'";
                }, explode(',', $middlewares))
            );

        $prefix = $this->option('prefix') ?? (convert_to_snake_case($resourceName). 's');

        $keys = ['{{Module}}', '{{module}}', '{{controller}}', '{{namespace}}', '{{version}}', '{{prefix}}', '{{middlewares}}'];
        $contentValues = [ucfirst($resourceName), strtolower(convertToSnakeCase($resourceName)), $this->option('controller') ?? "{$resourceName}Controller", $this->option('namespace-for-controller') ?? 'App\Http\Controllers\APIs\RESTful\V1', $this->option('versionning'), $prefix, $middlewares];

        $templateContent = File::get($templatePath);
        
        $generatedContent = str_replace($keys, $contentValues, $templateContent);

        // Check if the routes file already exists and force option is not provided
         if (File::exists($outputPath) && !$this->option('force')) {
            $apiRoutes = File::get($outputPath);
            if (strpos($apiRoutes, $generatedContent) === false) {
                // Append the route definitions to the api.php file
                File::append($outputPath, "\n$generatedContent\n");
                $this->info("\nAPI REST routes for '". ucfirst(strtolower($resourceName)) . " ' generated successfully in [". short_path($outputPath)."] .");
            } else {
                $this->warn("\nAPI REST routes for '". ucfirst(strtolower($resourceName)) . "' already exist in [". short_path($outputPath)."] .");

                return;
            }
        } else {
            // Create the file and add the route definitions
            File::put($outputPath, $generatedContent);

            $config = "// Load API routes from versions using the helper function\n\LaravelCoreModule\CoreModuleMaker\Helpers\Utils\Class\RouteHelper::loadApiRoutesFromVersions(base_path('routes/apis'));";
            
            // Generate the model file
            $routeContent = file_get_contents(base_path('routes/api.php'));

            // Check if the additional code is already present in the existing content
            if (strpos($routeContent, $config) === false) {

                File::append(base_path('routes/api.php'), "\n\n$config\n");
            }

            /*

            $routeContent .= 

            file_put_contents($modelFilePath, $modelContent); */

            $this->info("\nAPI REST routes for ". ucfirst(strtolower($resourceName)) . "' generated successfully in a new [". short_path($outputPath)."] file.");
        }
        
    }

}
