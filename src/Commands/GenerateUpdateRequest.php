<?php

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateUpdateRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:update-request 
                                {name? : The name of the update request class}
                                {--base=FormRequest : The base class for the request}
                                {--dir=app/Http/Requests : The directory to store the request}
                                {--namespace=App\Http\Requests : The namespace for the request}
                                {--model= : The model class associated with the request}
                                {--controller=App\Http\Controllers : Generate a corresponding controller}
                                {--api-version=v1 : Specify the API version for the request}
                                {--dto= : Update DTO}
                                {--dtoNamespace= : Update DTO namespace}
                                {--force : Force the generation even if the file already exists}
                                {--validation-rules : The validation rules for the request}
                                {--validation-messages : The validation messages for the request}
                                {--policy : Generate a policy for the request}
                                {--timestamp : Add a timestamp to the filename}
                                {--test : Request test}
                                {--interactive : Interactively prompt for missing options}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';



    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?? $name = $this->ask("Enter the update request class name should be in CamelCase (UpdateUserRequest) ", "UpdateUserRequest");
        $model = Str::studly(convertToSnakeCase($this->option('model') ?? $model = $this->ask("Enter the update request class name should be in CamelCase (User) ", "User")));
        $directory = $this->option('dir') ?? $this->ask('Enter the directory where the update request class should be placed (default: app/Http/Requests)', 'app/Http/Requests');

        $dto = Str::studly(convertToSnakeCase($this->option('dto') ?? $this->ask("Enter the dto where the update request class should be placed (default: Update{$model}DTO)", "Update{$model}DTO")));
        $dtoNamespace = $this->option('dtoNamespace') ?? $this->ask("Enter the data transfert object namespace where the update dto class should be placed (default: Modules\\{$model}s\\DataTransfertObjects)", "Modules\\{$model}s\\DataTransfertObjects");
    
        $update_stub = file_get_contents("./../stubs/requests/update.stub");

        $filename = base_path("$directory/$name.php");

        if (!file_exists("{$directory}/")) {
            createCascadeDirectories("{$directory}/");
        }

        if (File::exists($filename) && !$this->option("force")) {
            $this->warn('Request class ' . $name . ' already exists. Use --force to overwrite.');
            return;
        }
        
        $requestNamespace = ucfirst(str_replace(["/", ".php"], ["\\", ""], short_path($filename)));

        $namespace = ucfirst(str_replace(["/"], ["\\"], short_path($directory)));

        $update_stub = str_replace(['{{requestName}}', "{{requestNamespace}}", "{{Module}}", "{{module}}", "{{namespace}}", "{{dto}}", "{{dtoNamespace}}"], [$name, $requestNamespace, $model, strtolower(convertToSnakeCase($model)), $namespace, $dto, $dtoNamespace], $update_stub);
        
        file_put_contents($filename, $update_stub);
    
        $this->info("Request class " . '[' . short_path($filename) . ']' . " generated successfully!");

        $firstString = explode('\\', $dtoNamespace)[0];

        $file_path = str_replace($firstString, strtolower(convertToSnakeCase($firstString)), "{$dtoNamespace}\\{$dto}.php");

        if (!File::exists($file_path)){

            // Build the arguments and options for the "generate:update-dto" command
            $arguments = ['name' => $dto];
            $arguments['modelName'] = $model;
            $options['--namespace'] = $dtoNamespace;
            if($firstString !== 'App'){
                $options['--base_path'] = true;
                
                if($firstString === 'Modules'){
                    $options['--modules'] = true;
                }
            }
            
            $options['--path'] = str_replace($firstString . "\\", "", "{$dtoNamespace}");
            $options['--api-version'] = $this->option("api-version");
            
            if($this->option('force'))
                $options['--force'] = $this->option('force');

            // Execute the "generate:update-dto" command using the call method
            $this->call('generate:update-dto', array_merge($arguments, $options));

        }
        
    }

    /**
     * Execute the console command.
     *//* 
    public function handle()
    {
        $name = $this->argument('name') ?? $name = $this->ask('Enter the update request class name should be in CamelCase (UpdateUserRequest) ', 'UpdateUserRequest');
        $model = $this->option('model') ?? $model = $this->ask('Enter the request class name should be in CamelCase (User) ', 'User');
        $directory = $this->option('dir') ?? $this->ask('Enter the directory where the update request class should be placed (default: app/Http/Requests)', 'app/Http/Requests');
    
        $update_stub = file_get_contents(core_path() . '/Stubs/Requests/update.stub');

        $filename = base_path("$directory/$name.php");

        if (!file_exists("{$directory}/")) {
            updateCascadeDirectories("{$directory}/");
        }

        if (File::exists($filename) && !$this->option("force")) {
            $this->warn('Request class ' . $name . ' already exists. Use --force to overwrite.');
            return;
        }
        
        $requestNamespace = ucfirst(str_replace(["/", ".php"], ["\\", ""], short_path($filename)));

        $namespace = ucfirst(str_replace(["/"], ["\\"], short_path($directory)));

        $update_stub = str_replace(['{{requestName}}', "{{requestNamespace}}", "{{Module}}", "{{module}}", "{{namespace}}"], [$name, $requestNamespace, $model, strtolower($model), $namespace], $update_stub);
        
        file_put_contents($filename, $update_stub);
    
        $this->info("Request class " . '[' . short_path($filename) . ']' . " generated successfully!");
    } */
}
