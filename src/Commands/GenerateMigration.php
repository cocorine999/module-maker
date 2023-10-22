<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateMigration extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:migration
                            {name : The name of the migration}
                            {--table= : The name of the table}
                            {--action=modify : The action to perform (add, modify, delete)}
                            {--create= : The name of the table to be created}
                            {--connection=pgsql : The database connection to use}
                            {--path= : The location where the migration file will be created}
                            {--stub= : The path to the custom migration stub file}
                            {--columns= : The table columns}
                            {--model= : Create the model}
                            {--force : Force create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate migration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $action = $this->option('action');
        $table = $this->option('table');
        $createTable = $this->option('create');
        $connection = $this->option('connection');
        $path = $this->option('path');
        $stub = $this->option('stub');

        $columns = $this->option('columns') ?? '{}';

        // Convert the JSON string to an associative array
        $columns = json_decode($columns, true);

        if (!is_array($columns)) {
            $this->error("Invalid or empty columns format. Please provide columns in a valid JSON format.");
            return;
        }

        if (!$table && !$createTable) {
        
            $createTable = $this->ask("Please insert the table name (users) ", 'users');
            /* $this->error("Invalid or empty columns format. Please provide columns in a valid JSON format.");
            return; */
        }

        $migrationName = Str::snake($name);
        $migrationClassName = Str::studly(strtolower($migrationName));
        $migrationFileName = date('Y_m_d_His') . '_' . $migrationName . '.php';
        $migrationFilePath = $path ? $path . DIRECTORY_SEPARATOR . $migrationFileName : database_path('migrations') . DIRECTORY_SEPARATOR . $migrationFileName;

        if ($stub && !file_exists($stub)) {
            $this->error("The custom migration stub file does not exist: {$stub}");
            return;
        }

        // Define the base directory of the package
        $base_path = dirname(__DIR__, 2);

        // Build the full path to the file.
        $stub_path = "{$base_path}/stubs/migration.stub";

        ///$stub_path = "./../stubs/migration.stub";

        // Generate the migration file
        $stubContent = $stub ? file_get_contents($stub) : file_get_contents($stub_path);

        $stubContent = str_replace('{{className}}', $migrationClassName, $stubContent);
        $stubContent = str_replace('{{table_name}}', ($createTable ?? $table), $stubContent);
        $stubContent = str_replace('{{action}}', $createTable ? 'create' : $action, $stubContent);
        $stubContent = str_replace('{{connection}}', $connection, $stubContent);

        $stubContent = str_replace('{{columns}}', $this->generateColumns($columns), $stubContent);

        if (file_put_contents($migrationFilePath, $stubContent)) {
            $this->info("\nMigration " . "[" . short_path($migrationFilePath) . "] created successfully.\n");
        } else {
            $this->error("Failed to create migration: {$migrationFileName}");
        }

        if($this->option('model'))
        {

            $migrate = $this->ask("Do you want to migrate this table (y/n) ", 'y');
            
            if($migrate === 'n') return;

            // Execute the "migrate" command using the call method
            $this->call('migrate', [
                '--path' => short_path($migrationFilePath)
            ]);
            
            // Build the arguments and options for the "generate:model" command
            $arguments = ['name' => $this->option('model')];
            $options['--table'] = $createTable ?? $table;
            if($this->option('force'))
                $options['--force'] = $this->option('force');

            // Execute the "generate:model" command using the call method
            $this->call('generate:model', array_merge($arguments, $options));
        }
    }

    protected function preview(): void{

    }

    /**
     * Generate the column definitions for the migration.
     *
     * @param array $columns The associative array of columns
     * @return string The string representation of the column definitions
     */
    protected function generateColumns(array $columns): string
    {
        $columnDefinitions = [];

        foreach ($columns as $columnName => $options) {

            if($options['type'] === 'enum'){
                $value = "\$table->{$options['type']}('{$columnName}', " . json_encode($options['values']) . ")";
            }
            else{

                $value = "\$table->{$options['type']}('{$columnName}')";
            }

            if(isset($options['nullable']) && $options['nullable']){
                $value .= "->nullable()";
            }

            if(isset($options['default']) && $options['default']){
                $value .= "->default({$options['default']})";
            }

            if(isset($options['unique']) && $options['unique']){
                $value .= "->unique()";
            }
            
            $columnDefinitions[] = "$value;";
        }

        /* foreach ($columns as $columnName => $columnType) {
            $columnDefinitions[] = "\$table->{$columnType}('{$columnName}');";
        } */

        return implode("\n\t\t\t\t", $columnDefinitions);
    }

}