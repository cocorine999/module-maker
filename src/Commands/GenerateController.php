<?php

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateController extends Command
{
    protected $signature = 'generate:controller
                                {name : The name of the controller class} 
                                {--resource : Generate a resource controller}
                                {--model= : The name of the associated model}
                                {--namespace= : The namespace for the controller}
                                {--middleware= : Comma-separated list of middleware}
                                {--parent= : The parent controller class}
                                {--only= : Comma-separated list of methods to generate (for resource controller)}
                                {--except= : Comma-separated list of methods to exclude (for resource controller)}
                                {--force : Overwrite existing controller if it exists}
                                {--api : Generate a resourceful controller}
                                {--api-rest : Generate a resourceful controller}
                                {--with-form-requests : Generate FormRequest classes}
                                {--api-version=v1 : Specify the API version for the controller and related components}
                                {--request : request }
                                {--route : route }
                                {--repository : repository }
                                {--repository-namespace= : Path of the repository }
                                {--repository-base-path : Repository is at base path }
                                {--provider= : provider }
                                {--bindings : Generate route model bindings for controller methods that require them, automatically injecting the necessary model instances into your method}
                                {--service : Generate a corresponding service class for the controller, separating business logic from the controller itself}
                                {--requests : Generate request classes (form request validation) associated with the controller methods, enhancing your application\'s validation and security}';

    protected $description = 'Generate a new controller';

    /* public function handle()
    {

        $controllerName = Str::studly($this->argument('name'));

        if ($this->option('resource')) {
            Artisan::call('make:controller', [
                'name' => "{$controllerName}Controller",
                '--resource' => true,
            ]);
        } 
        else if ($this->option('api')) {
            Artisan::call('make:controller', [
                'name' => "{$controllerName}Controller",
                '--api' => true,
            ]);
        }
        else {
            Artisan::call('make:controller', [
                'name' => "{$controllerName}Controller",
            ]);
        }

        $this->info("Controller {$controllerName}Controller created successfully!");
    } */


    public function handle()
    {
        $controllerName = Str::studly(convertToSnakeCase($this->argument('name')));

        if($this->option('api'))
        {
            $path = "app/Http/Controllers/APIs";
        }
        elseif($this->option('api-rest'))
        {
            $path = "app/Http/Controllers/APIs/RESTful";
        }
        else $path = "app/Http/Controllers";
        
        $path = $this->ask("Enter the controller namespace where the create controller class should be placed (default: $path)", "$path");

        $path .= "/".ucfirst($this->option('api-version'));

        $controllerPath =  generate_path(str_replace('app/', '', $path)."/{$controllerName}.php");

        if (!file_exists("{$path}")) {
            createCascadeDirectories("{$path}");
        }

        if (file_exists($controllerPath) && !$this->option('force')) {
            $this->error('Controller already exists!');
            return;
        }

        $resourceName = Str::studly(convertToSnakeCase($this->option('model') ?? 'user'));

        $namespace = $namespace ?? ucfirst($path);
        $namespace = str_replace('/', '\\', $namespace);

        
        $requestPath = "app/Http/Requests/" . ucfirst($this->option("api-version"));

        if($this->option('model'))
        {
        
            $requestPath .= "/{$this->option('model')}s/" . strtolower($this->option("api-version"));

        }

        $requestNamespace = str_replace('/', '\\', ucfirst($requestPath));

        $controllerContent = $this->generateControllerContent(controllerName: $controllerName, namespace: $namespace, resourceName: $resourceName, requestNamespace: $requestNamespace );
        
        file_put_contents($controllerPath, $controllerContent);

        $this->info("Controller " . '[' . short_path($controllerPath) . ']' . " generated successfully.");

        if($this->option('repository'))
        {
            $providerName = $this->option('provider');
            if($providerName) $this->bindRepositories($resourceName, $namespace . "\\" . $controllerName, $providerName);
            else $this->bindRepositories($resourceName, $namespace . "\\" . $controllerName);
        }

        if($this->option('request')){

            $resourceName = Str::studly(convertToSnakeCase($resourceName));

            // Build the arguments and options for the "make:create-request" command
            $arguments = ['name' => "Create{$resourceName}Request"];
            $options['--model'] = $resourceName;
            $options['--api-version'] = $this->option("api-version");
            $options['--dir'] = $requestPath;
            if($this->option('force'))
                $options['--force'] = $this->option('force');

            // Execute the "generate:create-request" command using the call method
            $this->call('generate:create-request', [...$arguments, ...$options]);


            $resourceName = Str::studly(convertToSnakeCase($resourceName));

            // Build the arguments and options for the "make:update-request" command
            $arguments = ['name' => "Update{$resourceName}Request"];
            $options['--model'] = $resourceName;

            // Execute the "generate:update-request" command using the call method
            $this->call('generate:update-request', array_merge($arguments, $options));
        }

        if($this->option('route')){
            $params = [
                '--controller' => $controllerName,
                '--controller-path' => short_path($path),
                '--namespace-for-controller' => $namespace,
                '--versionning'     => $this->option('api-version'),
                '--force'     => $this->option('force'),
            ];

            $modelName = $this->option('model') ?? $modelName = $this->ask("Enter the model name CamelCase (User) ", "User");
      
            $route_resource = convert_to_kebab_case(convertToSnakeCase($modelName));

            $this->call('generate:resource-routes', [
                'name' => $route_resource,
                ...$params
            ]);
        }

    }

    protected function generateControllerContent($controllerName, $namespace = "App\Http\Controllers\APIs\RESTful\\v1", $resourceName = 'User', $requestNamespace = "App\Http\Requests")
    {

        // Define the base directory of the package
        $base_path = dirname(__DIR__, 2);

        // Build the full path to the file.
        $path = "{$base_path}/stubs/controller.stub";

        $resourceNamespace = "Modules\\" . $resourceName . "s\Services";
        $controllerStub = file_get_contents($path);

        return str_replace(['{{resourceController}}', '{{namespace}}', '{{module}}', '{{resourceNamespace}}', '{{resourceName}}', '{{requestNamespace}}'], [$controllerName, $namespace, strtolower($resourceName), $resourceNamespace, $resourceName, $requestNamespace], $controllerStub);
    }

    protected function bindRepositories(string $resourceName, string $controllerNamespace, string $providerName = "RepositoryServiceProvider")
    {

        $providerName = Str::studly(convertToSnakeCase($providerName));

        $providerPath = app_path("Providers/$providerName.php");
        
        if (!file_exists($providerPath)) {
            $this->call('generate:dynamic-provider', [
                'name' => $providerName 
            ]);
        }

        $repositoryNamespace = $this->option('repository-namespace') ?? ( ($this->option('repository-base-path')) ? "\Modules\\{$resourceName}s\Repositories\\" : "\App\Repositories\\");

        $fileContent = file_get_contents($providerPath);

        $functionName = 'register';

        $function = getFunctionContentFromFile($providerPath, $functionName, true);

        $registerReadOnlyRepository = "\n\t\t// Bind ReadOnlyRepositoryInterface to {$resourceName}ReadOnlyRepository";

        $registerReadOnlyRepository.= "\n\t\t\$this->app->when({$controllerNamespace}::class)";

        $registerReadOnlyRepository.= "\n\t\t\t->needs(\LaravelCoreModule\CoreModuleMaker\Repositories\Contracts\ReadOnlyRepositoryInterface::class)";

        $registerReadOnlyRepository.= "\n\t\t\t->give({$repositoryNamespace}{$resourceName}ReadOnlyRepository::class);";

        $fileContent = appendCodeToFunction($fileContent, $function, getFunctionContentFromFile($providerPath, $functionName), $registerReadOnlyRepository);

        // Save the modified content back to the file
        file_put_contents($providerPath, $fileContent);

        unset($function);
        unset($fileContent);
        unset($registerReadOnlyRepository);


        $fileContent = file_get_contents($providerPath);

        $function = getFunctionContentFromFile($providerPath, $functionName, true);

        $registerReadWriteRepository = "\n\t\t// Bind ReadWriteRepositoryInterface to {$resourceName}ReadWriteRepository";

        $registerReadWriteRepository.= "\n\t\t\$this->app->when({$controllerNamespace}::class)";

        $registerReadWriteRepository.= "\n\t\t\t->needs(\LaravelCoreModule\CoreModuleMaker\Repositories\Contracts\ReadWriteRepositoryInterface::class)";

        $registerReadWriteRepository.= "\n\t\t\t->give({$repositoryNamespace}{$resourceName}ReadWriteRepository::class);";


        $fileContent = appendCodeToFunction($fileContent, $function, getFunctionContentFromFile($providerPath, $functionName), $registerReadWriteRepository);

        // Save the modified content back to the file
        file_put_contents($providerPath, $fileContent);

        unset($fileContent);
        unset($repositoryNamespace);
        unset($function);
        unset($functionName);
        unset($providerPath);
        unset($providerName);
        unset($registerReadWriteRepository);
    }
}
