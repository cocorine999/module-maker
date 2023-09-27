<?php

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class GenerateCreateRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:create-request 
                                {name? : The name of the create request class}
                                {--base=FormRequest : The base class for the request}
                                {--dir=app/Http/Requests : The directory to store the request}
                                {--namespace=App\Http\Requests : The namespace for the request}
                                {--model= : The model class associated with the request}
                                {--controller=App\Http\Controllers : Generate a corresponding controller}
                                {--api-version=v1 : Specify the API version for the request}
                                {--dto= : DTO}
                                {--dtoNamespace= : DTO namespace}
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
        $name = $this->argument('name') ?? $name = $this->ask("Enter the create request class name should be in CamelCase (CreateUserRequest) ", "CreateUserRequest");
        $model = Str::studly(convertToSnakeCase($this->option('model') ?? $model = $this->ask("Enter the create request related model class name (User) ", "User")));
        $directory = $this->option('dir') ?? $this->ask('Enter the directory where the create request class should be placed (default: app/Http/Requests)', 'app/Http/Requests');

        $dto = Str::studly(convertToSnakeCase($this->option('dto') ?? $this->ask("Enter the dto where the create dto class should be placed (default: Create{$model}DTO)", "Create{$model}DTO")));
        $dtoNamespace = $this->option('dtoNamespace') ?? $this->ask("Enter the data transfert object namespace where the create dto class should be placed (default: Modules\\{$model}s\\DataTransfertObjects)", "Modules\\{$model}s\\DataTransfertObjects");
    
        // Define the base directory of the package
        $base_path = dirname(__DIR__, 2);

        // Build the full path to the file.
        $stub_path = "{$base_path}/stubs/requests/create.stub";

        $create_stub = file_get_contents($stub_path);

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

        $create_stub = str_replace(['{{requestName}}', "{{requestNamespace}}", "{{Module}}", "{{module}}", "{{namespace}}", "{{dto}}", "{{dtoNamespace}}"], [$name, $requestNamespace, $model, strtolower(convertToSnakeCase($model)), $namespace, $dto, $dtoNamespace], $create_stub);
        
        file_put_contents($filename, $create_stub);
    
        $this->info("Request class " . '[' . short_path($filename) . ']' . " generated successfully!");

        $firstString = explode('\\', $dtoNamespace)[0];

        $file_path = str_replace($firstString, strtolower(convertToSnakeCase($firstString)), "{$dtoNamespace}\\{$dto}.php");

        if (!File::exists($file_path)){

            // Build the arguments and options for the "generate:create-dto" command
            $arguments = ['name' => $dto];
            $options['--model'] = $model;
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

            // Execute the "generate:create-dto" command using the call method
            $this->call('generate:create-dto', array_merge($arguments, $options));

        }
        
    }
}
