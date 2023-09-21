<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class GenerateDTO extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:dto 
                                    {name : The name of the DTO class}
                                    {modelName : The name the associate model dto}
                                    {--modules : The base path to the dto class}
                                    {--base_path : The base path to the dto class}
                                    {--path= : The path to the dto class}
                                    {--namespace= : The namespace of the dto class}
                                    {--api-version=v1 : Specify the API version for the dto}
                                    {--force : Force create the dto}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Data Transfer Object (DTO)';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name      = $this->argument('name');
        $modelName = Str::studly(convertToSnakeCase($this->argument('modelName')));
        $dtoName   = Str::studly(convertToSnakeCase($name));
        $base_path = $this->option('base_path');
        $path      = $this->option('path');
        $namespace = $this->option('namespace');
        $modules   = $this->option('modules');

        $inter_path = null;
        if(!$path) $inter_path = $modelName . 's';
        if ($base_path) {
            ///$path = str_replace('\\', '/', $path);
            $path = generate_path(path: $path ? ($modules ? "modules/{$path}" : "dataTransfertObjects/{$path}") : ($modules ? "modules/" . $inter_path . '/DataTransfertObjects' : "dataTransfertObjects/" . $inter_path), type: 'base');
            
            ///$path = generate_path(path: $path ? ($modules ?  "modules/{$path}" : "dataTransfertObjects/{$path}") : ($modules ? "modules/{$inter_path}/DataTransfertObjects" : "dataTransfertObjects/{$inter_path}" ), type: 'base');
            $namespace = $namespace ?? ucfirst(short_path($path));
        }
        else{
            $path = generate_path(path: $path ? $path : "{$path}/DataTransfertObjects/" . $inter_path);
            $namespace = $namespace ?? ucfirst(short_path($path));
        }

        $namespace = str_replace('/', '\\', $namespace);

        $params = [
            'modelName' => $modelName,
            '--namespace' => $namespace,
            '--path'      => short_path($path, 'base'), 
            '--path_type' => short_path($path, $this->option('base_path') ? 'base' : 'app'), 
            '--api-version'     => $this->option('api-version'),
            '--force'     => $this->option('force'),
        ];

        $createDTO = "Create{$dtoName}DTO";

        $this->call('generate:create-dto', [
            'name' => $createDTO,
            ...$params
        ]);

        // Create the update dto class file
        $updateDTO = "Update{$dtoName}DTO";
        
        $this->call('generate:update-dto', [
            'name' => $updateDTO,
            ...$params
        ]);
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
                    elseif(!empty($value)) $data[] = "\"$value\""; 
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

            $ruleDefinitions[] = "\t\t\t\"$name\" $space \t\t=> [". implode(", ", $data) . "],";
        }

        return implode("\n", $ruleDefinitions);
    }
}
