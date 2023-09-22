<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class GenerateRepository extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:repository 
                                {name : The name of the repository}
                                {--model= : The name of the associate model repository}
                                {--modules : The base path to the repository class}
                                {--base_path : The base path to the repository class}
                                {--path= : The path to the repository class}
                                {--namespace= : The namespace of the repository class}
                                {--force : Force create the repository}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate read-only and read-write repository';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $modelName = $this->option('model') ?? $modelName = $this->ask("Enter the model name CamelCase (User) ", "User");

        $force = $this->option('force');
        $repositoryName = Str::studly(convertToSnakeCase($name));
        $base_path = $this->option('base_path');
        $path = $this->option('path');
        $namespace = $this->option('namespace');
        $modules = $this->option('modules');

        $inter_path = null;
        if (!$path) $inter_path = $modelName . 's';
        if ($base_path) {
            $path = generate_path(path: $path ? ($modules ?  "modules/{$path}" : "repositories/{$path}") : ($modules ? "modules/{$inter_path}/Repositories" : "repositories/{$inter_path}"), type: 'base');
            $namespace = $namespace ?? ucfirst(short_path($path));
        } else {
            $path = generate_path(path: $path ? $path : "{$path}/Repositories/" . $inter_path);
            $namespace = $namespace ?? ucfirst(short_path($path));
        }

        $namespace = str_replace('/', '\\', $namespace);

        // Create the read-write repository class file
        $filesystem = new Filesystem();
        $writeRepositoryClass = "{$repositoryName}ReadWriteRepository";
        $writeClassFilePath = "{$path}/{$writeRepositoryClass}.php";

        if (!file_exists("{$path}"))
            createCascadeDirectories("{$path}");

        if (!$force && $filesystem->exists($writeClassFilePath)) {
            $this->error("Repository {$writeRepositoryClass} already exists.");
            return;
        }

        // Define the base directory of the package
        $base_folder = dirname(__DIR__, 2);

        // Build the read-write repository class full path to the file.
        $stub_path = "{$base_folder}/stubs/repositories/write.stub";

        // Create the read-write repository class
        //$stub_path = "./../stubs/repositories/write.stub";
        
        $classStub = file_get_contents($stub_path);
        $classStub = str_replace(['{{moduleName}}', '{{modelName}}', '{{namespace}}'], [$repositoryName, $modelName, $namespace], $classStub);
        $filesystem->put($writeClassFilePath, $classStub);

        $providerPath = app_path('Providers/RepositoryServiceProvider.php');
        if (!file_exists($providerPath)) {
            $this->call('generate:dynamic-provider', [
                'name' => 'RepositoryServiceProvider',
            ]);
        }

        // Create the read-only repository class file
        $readFilesystem = new Filesystem();
        $readOnlyRepositoryClass = "{$repositoryName}ReadOnlyRepository";
        $readOnlyClassFilePath = "{$path}/{$readOnlyRepositoryClass}.php";

        if (!file_exists("{$path}"))
            createCascadeDirectories("{$path}");

        if (!$force && $readFilesystem->exists($readOnlyClassFilePath)) {
            $this->error("Repository {$readOnlyRepositoryClass} already exists.");
            return;
        }

        // Define the base directory of the package
        $base_folder = dirname(__DIR__, 2);

        // Build the read-only repository class full path to the file.
        $stub_path = "{$base_folder}/stubs/repositories/read_only.stub";

        // Create the read-only repository class
        //$stub_path = "./../stubs/repositories/read_only.stub";
        
        $classStub = file_get_contents($stub_path);
        $classStub = str_replace(['{{moduleName}}', '{{modelName}}', '{{namespace}}'], [$repositoryName, $modelName, $namespace], $classStub);
        $readFilesystem->put($readOnlyClassFilePath, $classStub);
        
        $this->info("Repository " . '[' . short_path($writeClassFilePath) . ']' . " created successfully.\n");
        $this->info("Repository " . '[' . short_path($readOnlyClassFilePath) . ']' . " created successfully.\n");

        if ($base_path) autoload_folder(extract_string(short_path($path)));
    }
}
