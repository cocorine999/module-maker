<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateModel extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:model
                                {name : The name of the model}
                                {--table=users : The associated table of the model}
                                {--connection=pgsql : The connection name to the associated table of the model}
                                {--namespace=Core : ModelContract namespace}
                                {--force : Force create the model}
                                {--pivot : The Model is a pivot}
                                {--repository : The associate repository to the model}
                                {--repository-namespace=App\Repositories : The Model is a pivot}
                                {--fillable= : The fillable attributes separated by commas}';

    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model with table column attributes';


    /**
     * Execute the console command.
     */
    public function handle()
    {

        $name = Str::studly(convertToSnakeCase($this->argument('name')));

        // Check if the model file already exists
        $modelFilePath = app_path('Models/'.$name.'.php');
        if (File::exists($modelFilePath) && !$this->option('force')) {

            $this->warn('Model already exists. Please choose a different name.');

            $create_model = $this->ask("Do you want to force create this model (y/n) ", 'y');
            
            if($create_model === 'n') return;
        }

        $namespace = $this->option('namespace');
        $table = $this->option('table');
        $connection = $this->option('connection');
        $fillable = $this->option('fillable');
        $pivot = $this->option('pivot');

        //$path = "src/package-skeleton-laravel/stubs/model.stub";

        // Define the base directory of the package
        $base_path = dirname(__DIR__, 2);

        // Build the full path to the file.
        $stub_path = "{$base_path}/stubs/model.stub";
        
        // Generate the model file
        $modelStub = file_get_contents($stub_path);

        $info = new ('LaravelCoreModule\CoreModuleMaker\Eloquents\Contract\ModelContract');

        $exclude[] = $info->deleteable();

        $exclude = array_keys(array_merge(array_merge(array_flip($info->default_fillable), array_flip($info->default_visible)), array_flip($info->default_guarded)));

        if(is_null($attributes = tableSchema($table, $connection))){
            exit("Table doesn't exists. Please migrate the table $table.");
            $this->error("Table doesn't exists. Please migrate the table $table.");
            return null;
        }

        if(is_null($fillableAttributesWithCast = $this->getTableSchema($table, $connection, $exclude))){
            $this->error('Table doesn\'t exists. Please migrate the table.');
            return;
        }

        $fillableAttributes = array_map(function ($attr) {
            return explode(':', $attr)[0];
        }, $fillableAttributesWithCast);
        
        $fillable = !empty($fillableAttributes) ? "'".implode("',\n        '", $fillableAttributes)."'" : '';

        $properties = !empty($fillableAttributes) ? '@property  ' . $this->getFillablePropertyTypes($fillableAttributesWithCast, $exclude) : '';

        $fillableCast = !empty($fillableAttributesWithCast) ? implode(",\n        ", casts(fillableAttributes: $fillableAttributesWithCast, excludeColumns: $exclude)) : '';
        
        $replace_value = ['{{properties}}', '{{modelName}}', '{{connection}}', '{{table}}', '{{fillableAttributes}}', '{{fillableCast}}', '{{datesFillable}}', '{{attributes}}'];
        $replace_key = [$properties, $name, $connection, $table, $fillable, $fillableCast, $this->getDatesAttributes($attributes, $exclude), $this->getDefaultAttributesWithValues($attributes, $exclude) ];

        if($pivot){
            $replace_value = array_merge($replace_value, ['{{trait}}', '{{importation}}']);
            $replace_key = array_merge($replace_key, ['use AsPivot;', 'use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;']);
        }
        else{
            $replace_value = array_merge($replace_value, ['{{trait}}', '{{importation}}']);
            $replace_key = array_merge($replace_key, ['', '']);
        }

        $modelContent = str_replace($replace_value, $replace_key, $modelStub);

        // Save the model file
        $modelFilePath = app_path('Models/'.$name.'.php');
        file_put_contents($modelFilePath, $modelContent);
    
        $this->info("Model " . '[' . short_path($modelFilePath) . ']' . " created successfully.");

        if($this->option('repository'))
        {

            $repositoryName = $this->ask("Enter the model name CamelCase ($name) ", "$name");
    
            $repositoryName =  Str::studly(convertToSnakeCase($repositoryName));

            $repositoryNamespace = $this->option('repository-namespace');
    
            $firstString = explode('\\', $repositoryNamespace)[0];

            $file_path = str_replace([$firstString, "\\"], [strtolower(convertToSnakeCase($firstString)), '/'], "{$repositoryNamespace}\\{$repositoryName}.php");

            if (!File::exists($file_path)){

                // Build the arguments and options for the "generate:repository" command
                $arguments = ['name' => $repositoryName];
                $options['--model'] = $name;
                $options['--namespace'] = $repositoryNamespace;
                if($firstString !== 'App'){
                    $options['--base_path'] = true;
                    
                    if($firstString === 'Modules'){
                        $options['--modules'] = true;
                    }
                }

                $options['--path'] = str_replace($firstString . "\\", "", "{$repositoryNamespace}");
                
                if($this->option('force'))
                    $options['--force'] = $this->option('force');

                // Execute the "generate:repository " command using the call method
                $this->call('generate:repository', array_merge($arguments, $options));
                
            }

        }
    }

    /**
     * Get the property types for fillable attributes with cast keys.
     *
     * @param array $fillableAttributesWithCast
     * @return string
     */
    protected function getFillablePropertyTypes(array $fillableAttributesWithCast): string
    {
        $fillableTypes = [];
        foreach ($fillableAttributesWithCast as $attribute) {
            $parts = explode(':', $attribute, 2);
            $space = '';
            if (count($parts) === 2) {
                [$attributeName, $castType] = $parts;
                
                for ($i=(8 - strlen($castType)); $i > 0; --$i) {
                    $space .= ' ';
                }
                $fillableTypes[] = "{$castType} {$space} \${$attributeName};";
            }
            else{
                $fillableTypes[] = "string {$space} \${$parts[0]};";
            }
        }

        return implode("\n * @property  ", $fillableTypes);

    }

    /**
     * Get the table schema for the given table and connection.
     *
     * @param string $table
     * @param string $connection
     * @param array  $excludeColumns
     * @return array|null
     */
    protected function getTableSchema(string $table, string $connection, array $excludeColumns = []): array|null
    {

        if(is_null($attributes = tableSchema($table, $connection))){
            $this->error('Table doesn\'t exists. Please migrate the table.');
            return null;
        }

        return array_filter(array_map(function($attribute, $key) use ($excludeColumns) {
            if(!in_array($key, $excludeColumns, true))
                return $key . ':' . $attribute['type'];
            return null;
        }, $attributes, array_keys($attributes)));

    }

    public function getDatesAttributes(array $attributes, array $excludes = [])
    {

        $dates = array_filter(array_map(function($attribute, $key) use ($excludes) {
            if(!in_array($key, $excludes, true) && $attribute['type'] === 'datetime'){
                return "'$key'";
            }
        }, $attributes, array_keys($attributes)));

        return implode(",\n        ", $dates);
    }

    public function getDefaultAttributesWithValues(array $attributes, array $excludes = [])
    {

        $extract_attributes = array_filter(array_map(function ($string) use ($excludes, $attributes){
            if(!in_array($string, $excludes, true) && !$attributes[$string]['default']){
                return strlen($string);
            }
            return null;
        }, array_keys($attributes)));

        if(!empty($extract_attributes)) $maxStringLength = max($extract_attributes);
        else $maxStringLength = 0;

        $defaultAttributesWithValues = array_filter(array_map(function($attribute, $key) use ($excludes, $maxStringLength) {

            if(!in_array($key, $excludes, true))
            {
                if($attribute['default'])
                {
                    $space = '';

                    for ($i=($maxStringLength - strlen($key)); $i > 0; --$i) {
                        $space .= ' ';
                    }

                    $value = $attribute['type'] === 'integer' ? $attribute['default'] : ($attribute['type'] === 'boolean' ? ($attribute['default'] ? 'TRUE' : 'FALSE') : "'{$attribute['default']}'");
                    
                    return "'{$key}' $space => $value";
                }
            }
        }, $attributes, array_keys($attributes)));
        
        return implode(",\n        ", array_filter($defaultAttributesWithValues));

    }
    
}