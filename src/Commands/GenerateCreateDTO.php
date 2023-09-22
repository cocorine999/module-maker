<?php

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;


class GenerateCreateDTO extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:create-dto 
                                {name : The name of the DTO class}
                                {--model= : The name the associate model dto}
                                {--modules : The base path to the dto class}
                                {--base_path : The base path to the dto class}
                                {--path= : The path to the dto class}
                                {--path_type=base : The path type}
                                {--namespace= : The namespace of the dto class}
                                {--api-version=v1 : Specify the API version for the dto}
                                {--force : Force create the dto}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Create a Data Transfer Object (DTO)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name      = $this->argument('name');

        $modelName = $this->option('model') ?? $modelName = $this->ask("Enter the model name CamelCase (User) ", "User");

        $force     = $this->option('force');
        $createDtoName   = Str::studly(convertToSnakeCase($name));
        $base_path = $this->option('base_path');
        $path      = $this->option('path');
        $namespace = $this->option('namespace');
        $modules   = $this->option('modules');

        $inter_path = null;
        if(!$path) $inter_path = $modelName . 's';
        if ($base_path) {
            $path = str_replace('\\', '/', $path);
            $path = generate_path(path: $path ? ($modules ?  "modules/{$path}" : "dataTransfertObjects/{$path}") : ($modules ? "modules/{$inter_path}/DataTransfertObjects" : "dataTransfertObjects/{$inter_path}" ), type: 'base');
            $namespace = $namespace ?? ucfirst(short_path($path));
        }
        else{
            $path = generate_path(path: $path ? $path : "{$path}/DataTransfertObjects/" . $inter_path, type: $this->option('path_type'));
            $namespace = $namespace ?? ucfirst(short_path($path));
        }

        $namespace = str_replace('/', '\\', $namespace);

        if (!class_exists("App\\Models\\$modelName")) {
            $this->info("Model not exist");
        }

        $model = new ("App\\Models\\{$modelName}")();

        if(is_null($attributes = tableSchema($model->getTable(), $model->getConnectionName()))){
            $this->error('Table doesn\'t exists. Please migrate the table.');
            return;
        }

        // Create the create dto class file
        $filesystem = new Filesystem();
        $createDTOClassFilePath = "{$path}/{$createDtoName}.php";

        if (!file_exists("{$path}"))
            createCascadeDirectories("{$path}");

        if (!$force && $filesystem->exists($createDTOClassFilePath)) {
            $this->error("Data Transfert Object {$createDtoName} already exists.");
            return;
        }

        // Define the base directory of the package
        $base_path = dirname(__DIR__, 2);

        // Build the create dto class full path to the file.
        $stub_path = "{$base_path}/stubs/dtos/create.stub";

        // Create the create dto class
        ///$classStub = file_get_contents(base_path()."/./../stubs/dtos/create.stub");
        $classStub = file_get_contents($stub_path);
        $classStub = str_replace(['{{CreateDtoName}}', '{{modelName}}', '{{namespace}}', '{{rules}}', '{{messages}}'], [$createDtoName, $modelName, $namespace, $this->generateRules($attributes), "[]"], $classStub);
        $filesystem->put($createDTOClassFilePath, $classStub);


        $this->info("Create Data Transfert Object " . '[' . short_path($createDTOClassFilePath) . ']' . " created successfully.");

        if($base_path) autoload_folder(extract_string(short_path($path)));
    }

    /**
     * Generate the rules definitions for the migration.
     *
     * @param array $rules The associative array of rules
     * @return string The  representation of the rules definitions
     */
    protected function generateRules(array $rules): string
    {

        $maxLength = strlen(getMaxStringLength(array_keys($rules)));

        $ruleDefinitions = [];

        $start = 0;

        foreach ($rules as $name => $infos) {

            $data = [];
            foreach ($infos as $key => $value) {

                $data = [];
                foreach ($infos as $key => $value) {
                    if($key === 'nullable'){
                        $value = $value ? 'required' : 'sometimes';
                        $data[] = "\"$value\""; 
                    }
                    elseif(!empty($value) && !is_bool($value)) $data[] = "\"$value\""; 
                }
            }

            $space = '';

            for ($i=($maxLength - strlen($name)); $i > 0; --$i) {
                $space .= ' ';
            }
            
            if($start === 0)
                $ruleDefinitions[] = "\"$name\" $space \t\t=> [". implode(", ", $data) . "],";
            else
                $ruleDefinitions[] = "\t\t\t\"$name\" $space \t\t=> [". implode(", ", $data) . "],";
            $start++;
        }

        return implode("\n", $ruleDefinitions);
    }
}
