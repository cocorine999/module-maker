<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class GenerateService extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:service 
                                    {name : The name of the service}
                                    {--base_path : The base path to the repository class}
                                    {--path= : The path to the repository class}
                                    {--namespace= : The namespace of the repository class}
                                    {--modules : The base path to the repository class}
                                    {--model= : The name of the associate model service}
                                    {--dto : The associate dto to the service}
                                    {--force : Force create the service}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a write and read service';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $force = $this->option('force');
        $serviceName = Str::studly(convertToSnakeCase($name));
        $base_path = $this->option('base_path');
        $path = $this->option('path');
        $namespace = $this->option('namespace');
        $modules = $this->option('modules');

        $inter_path = null;
        if(!$path){ 
            $inter_path = $name . 's';
        }
        if ($base_path) {
            //$path = generate_path(path: $path ? ($modules ? "modules/{$path}" : "services/{$path}") : ($modules ? "modules/" . $inter_path . '/Services/RESTful' : "services/" . $inter_path . '/RESTful'), type: 'base');
            $path = $path ? ($modules ? "modules/{$path}" : "services/{$path}") : ($modules ? "modules/" . $inter_path . '/Services/RESTful' : "services/" . $inter_path . '/RESTful');

            $path = $this->ask("Enter the path to the service ($path) ", "$path");

            $path = generate_path($path, type: 'base');
        }
        else{
            //$path = generate_path(path: $path ? $path : "{$path}/Services/" . $inter_path . '/RESTful');

            $path = $path ? $path : "{$path}/Services/" . $inter_path . '/RESTful';

            $path = $this->ask("Enter the path to the service ($path) ", "$path");

            $path = generate_path($path);
        }

        $namespace = str_replace('/', '\\', ($namespace ?? ucfirst(short_path($path))));

        // Create the read-write service class file
        $filesystem = new Filesystem();
        $readWriteServiceClass = "{$serviceName}RESTfulReadWriteService";
        $readWriteServiceInterface = "{$serviceName}RESTfulReadWriteServiceContract";
        $classFilePath = "{$path}/{$readWriteServiceClass}.php";
        $interfaceFilePath = "{$path}/Contracts/{$readWriteServiceInterface}.php";

        if (!file_exists("{$path}")) {
            createCascadeDirectories("{$path}");
        }
        if (!file_exists("{$path}/Contracts")) {
            createCascadeDirectories("{$path}/Contracts");
        }

        if (!$force && $filesystem->exists($classFilePath) || !$force && $filesystem->exists($interfaceFilePath)) {
            $this->error("Service {$readWriteServiceClass} or {$readWriteServiceInterface} already exists.");
            return;
        }

        // Define the base directory of the package
        $base_folder = dirname(__DIR__, 2);


        // Create the read-write service class

        // Build the read-write service class full path to the file.
        $stub_path = "{$base_folder}/stubs/services/restful/write.stub";

        $classStub = file_get_contents($stub_path);
        $classStub = str_replace(['{{moduleName}}', '{{namespace}}'], [$serviceName, $namespace], $classStub);
        $filesystem->put($classFilePath, $classStub);

        // Create the read-write service interface

        // Build the read-write service interface full path to the file.
        $stub_path = "{$base_folder}/stubs/services/restful/contracts/write_contract.stub";

        $interfaceStub = file_get_contents($stub_path);
        $interfaceStub = str_replace(['{{moduleName}}', '{{namespace}}'], [$serviceName, $namespace], $interfaceStub);
        $filesystem->put($interfaceFilePath, $interfaceStub);

        $this->info("Service " . '[' . short_path($classFilePath) . ']' . " created successfully.\n");
        $this->info("Interface " . '[' . short_path($interfaceFilePath) . ']' . " created successfully.\n");
        
        $providerPath = app_path('Providers/ModuleServiceProvider.php');
        
        if (!file_exists($providerPath)) {
            $this->call('generate:dynamic-provider', [
                'name' => 'ModuleServiceProvider',
            ]);
        }

        $fileContent = file_get_contents($providerPath);

        $functionName = 'register';

        $function = getFunctionContentFromFile($providerPath, $functionName, true);

        if(preg_match('/^(.*?)\\\\Services/', $namespace, $matches))
        {
            $repository_namespace = $matches[1];
        }
        
        $repositoryName = "{$serviceName}ReadWriteRepository";
        $repositoryNamespace = $this->option("base_path") && $this->option("modules") ? "{$repository_namespace}\Repositories" : "App\Repositories\\{$repository_namespace}";
        $repositoryNamespace = $this->ask("Enter the read write repository with his namespace ({$repositoryNamespace}\\{$repositoryName}) ", "{$repositoryNamespace}\\{$repositoryName}");

        $registerWriteService = "        // Binds the implementation of $readWriteServiceInterface to the $readWriteServiceClass class.\n        \$this->app->bind(\n            \\".convert_file_path_to_namespace($interfaceFilePath)."::class,\n            function (\$app) {\n                // Resolve the dependencies required by \\".convert_file_path_to_namespace($classFilePath)."$\n                \$".lcfirst($serviceName)."ReadWriteRepository = \$app->make(\\{$repositoryNamespace}::class);\n \n                \$writeService = \$app->make(\n                    \LaravelCoreModule\CoreModuleMaker\Services\Contracts\ReadWriteServiceContract::class,\n                    [\$".lcfirst($serviceName)."ReadWriteRepository]\n                );\n \n                // Create and return an instance of $readWriteServiceClass\n                return new \\".convert_file_path_to_namespace($classFilePath)."(\$writeService);\n            }\n        );";

        $fileContent = appendCodeToFunction($fileContent, $function, getFunctionContentFromFile($providerPath, $functionName), $registerWriteService);

        // Save the modified content back to the file
        file_put_contents($providerPath, $fileContent);
        
        // Create the query service class file
        $queryServiceClass = "{$serviceName}RESTfulQueryService";
        $queryServiceInterface = "{$serviceName}RESTfulQueryServiceContract";
        $classFilePath = "{$path}/{$queryServiceClass}.php";
        $interfaceFilePath = "{$path}/Contracts/{$queryServiceInterface}.php";

        if (!$force && $filesystem->exists($classFilePath) || !$force && $filesystem->exists($interfaceFilePath)) {
            $this->error("Service {$queryServiceClass} or {$queryServiceInterface} already exists.");
            return;
        }

        // Create the query service class

        // Build the query service class full path to the file.
        $stub_path = "{$base_folder}/stubs/services/restful/query.stub";

        $classStub = file_get_contents($stub_path);
        $classStub = str_replace(['{{moduleName}}', '{{namespace}}'], [$serviceName, $namespace], $classStub);
        $filesystem->put($classFilePath, $classStub);

        // Create the query service interface

        // Build the query service interface full path to the file.
        $stub_path = "{$base_folder}/stubs/services/restful/contracts/query_contract.stub";

        $interfaceStub = file_get_contents($stub_path);
        $interfaceStub = str_replace(['{{moduleName}}', '{{namespace}}'], [$serviceName, $namespace], $interfaceStub);
        $filesystem->put($interfaceFilePath, $interfaceStub);

        $this->info("Service " . '[' . short_path($classFilePath) . ']' . " created successfully.\n");
        $this->info("Interface " . '[' . short_path($interfaceFilePath) . ']' . " created successfully.\n");


        $repositoryName = "{$serviceName}ReadOnlyRepository";
        //$repositoryNamespace = $this->option("base_path") && $this->option("modules") ? "Modules\\{$serviceName}s\Repositories" : "App\Repositories\\{$serviceName}s";
        $repositoryNamespace = $this->option("base_path") && $this->option("modules") ? "{$repository_namespace}\Repositories" : "App\Repositories\\{$repository_namespace}";
        $repositoryNamespace = $this->ask("Enter the read only repository with his namespace ({$repositoryNamespace}\\{$repositoryName}) ", "{$repositoryNamespace}\\{$repositoryName}");

        $registerReadService = "        // Binds the implementation of $queryServiceInterface to the $queryServiceClass class.\n        \$this->app->bind(\n            \\".convert_file_path_to_namespace($interfaceFilePath)."::class,\n            function (\$app) {\n                // Resolve the dependencies required by \\".convert_file_path_to_namespace($classFilePath)."$\n                \$".lcfirst($serviceName)."ReadOnlyRepository = \$app->make(\\{$repositoryNamespace}::class);\n \n                \$queryService = \$app->make(\n                    \LaravelCoreModule\CoreModuleMaker\Services\Contracts\QueryServiceContract::class,\n                    [\$".lcfirst($serviceName)."ReadOnlyRepository]\n                );\n \n                // Create and return an instance of $queryServiceClass\n                return new \\".convert_file_path_to_namespace($classFilePath)."(\$queryService);\n            }\n        );";
        
        $function = getFunctionContentFromFile($providerPath, $functionName, true);
                
        $fileContent = file_get_contents($providerPath);

        $fileContent = appendCodeToFunction($fileContent, $function, getFunctionContentFromFile($providerPath, $functionName), $registerReadService);


        // Save the modified content back to the file
        file_put_contents($providerPath, $fileContent); 
        
        if($base_path) autoload_folder(extract_string(short_path($path)));

        if($this->option('dto'))
        {
            $modelName = $this->option('model') ?? $modelName = $this->ask("Enter the model name CamelCase (User) ", "User");

            // Build the arguments and options for the "generate:model" command
            $arguments = ['name' => $modelName];
            $options['--model'] = $modelName;
            $options['--path'] = str_replace("Modules\\", "", $repository_namespace);
            ///$options['--namespace'] = "{$repository_namespace}\DataTransfertObjects";
            if($this->option('force'))
                $options['--force'] = $this->option('force');
            if($this->option('modules'))
                $options['--modules'] = $this->option('modules');
            if($this->option('base_path'))
                $options['--base_path'] = $this->option('base_path');

            // Execute the "generate:model" command using the call method
            $this->call('generate:dto', array_merge($arguments, $options));
        }

        exec('composer dump-autoload');

        unset($filesystem);
        unset($fileContent);
        unset($function);
        unset($registerReadService);
        unset($interfaceStub);
        unset($$interfaceFilePath);
    }
}
