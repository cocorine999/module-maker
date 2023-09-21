<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


if (!function_exists('core_path')) {

    /**
     * Get the path to the base of the install.
     *
     * @param  string  $path  The optional path within the base directory.
     * @return string         The full path to the specified location within the base directory.
     */
    function core_path($path = '')
    {
        return app()->basePath('core/' . $path);
    }
}

if (!function_exists('module_path')) {

    /**
     * Get the path to the base of the install.
     *
     * @param  string  $path  The optional path within the base directory.
     * @return string         The full path to the specified location within the base directory.
     */
    function module_path($path = '')
    {
        return app()->basePath('modules/' . $path);
    }
}

if (!function_exists('generate_path')) {

    /**
     * Generate the path
     *
     * @param  string  $path  The optional path within the base directory.
     * @return string         The full path to the specified location within the base directory.
     */
    function generate_path(string $path = '', string $type = 'app',)
    {
        if ($type === 'app') {
            return app()->path($path);
        } else {
            $position = strpos($path, '/');
            if ($position)
                $base_name = substr($path, 0, $position);
            else $base_name = '';
            $path = strtolower($base_name) . substr($path, strlen($base_name));
            return app()->basePath($path);
        }
    }
}

if (!function_exists('loadModel')) {

    function loadModel(string $className)
    {
        $modelNamespace = 'App\\Models\\';
        $fullClassName = $modelNamespace . $className;

        if (class_exists($fullClassName)) {
            return new $fullClassName;
        }

        return null;
    }
}

function loadTables()
{
    $tables = [];

    foreach (getModelsInFolder(app_path('Models')) as $model) {
        $tables[] = $model->getTable();
    }

    return $tables;
}

if (!function_exists('loadModels')) {
    function loadModels()
    {
        $models = getModelsInFolder(app_path('Models'));

        $tables = [];

        foreach ($models as $model) {
            $modelName = class_basename($model);
            $tableName = $model->getTable();

            $tables[] = $model->getTable();

            // You can use $modelName and $tableName as needed.
            // For example, you can log them or store them in a configuration file.
            // In this example, we'll print them.
            echo "Model: $modelName, Table: $tableName" . PHP_EOL;
        }

        /* $modelsPath = app_path('Models'); // Change the folder path as needed

        $models = File::files($modelsPath);

        foreach ($models as $model) {
            $className = 'App\\Models\\' . pathinfo($model, PATHINFO_FILENAME);
            
            if (class_exists($className)) {
                $tableName = with(new $className)->getTable();
                dump("Model: $className, Table: $tableName");
            }
        } */

        return $tables;

    }
}


function getModelsInFolder($folder)
{
    $models = [];
    $files = scandir($folder);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $filePath = $folder . '/' . $file;
        $className = Str::before($file, '.php');

        if (is_file($filePath) && class_exists($className)) {
            $models[] = new $className();
        }
    }

    return $models;
}

if (!function_exists('class_exists')) {
    /**
     * Check if a class exists in the Laravel application.
     *
     * @param string $className
     * @return bool
     */
    function classExists($className)
    {
        return class_exists($className);
    }
}

if (!function_exists('extract_string')) {

    function extract_string(string $string, string $indice = '/', int $start_index = 0)
    {

        $position = strpos($string, $indice);
        if ($position)
            return substr($string, $start_index, $position);
        else return $string;
    }
}

if (!function_exists('autoload_folder')) {
    function autoload_folder(string $folderName, ?string $NewNamespace = null)
    {
        // Add the folder to the autoload configuration (optional)
        $composerJsonPath = base_path('composer.json');
        $composerJson = json_decode(file_get_contents($composerJsonPath), true);

        $NewNamespace = $NewNamespace ?? ucfirst(strtolower($folderName));

        if (!isset($composerJson['autoload']['psr-4']["{$NewNamespace}\\"])) {
            $composerJson['autoload']['psr-4']["{$NewNamespace}\\"] = $folderName . '/';
            file_put_contents($composerJsonPath, json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            // Run the composer dump-autoload command
            exec('composer dump-autoload');
        }
    }
}

if (!function_exists('short_path')) {

    /**
     * Convert a full file path to a shorter, relative path from the application root.
     *
     * @param string $modelFilePath The full file path to convert.
     * @return string The relative file path from the application root.
     */
    function short_path($modelFilePath = '')
    {
        $path = str_replace(base_path(), '', $modelFilePath);
        $first_character = substr($path, 0, 1);

        if ($first_character === '/') {
            return substr($path, 1);
        }

        return $path;
    }
}

if (!function_exists('convert_to_snake_case')) {

    /**
     * Convert a given string to snake_case.
     *
     * @param string $string The input string to convert.
     * @return string The string converted to snake_case.
     */
    function convert_to_snake_case(string $string): string
    {
        $modifiedString = preg_replace('/(?<!^)([A-Z])/', '_$1', $string);
        return strtolower($modifiedString);
    }
}

if (!function_exists('convert_to_kebab_case')) {

    /**
     * Convert a given string to kebab_case.
     *
     * @param string $string The input string to convert.
     * @return string The string converted to kebab_case.
     */
    function convert_to_kebab_case(string $string): string
    {
        // Replace spaces with hyphens and convert to lowercase
        return str_replace('_', '-', convert_to_snake_case($string));
    
    }
}

if (!function_exists('createCascadeDirectories')) {
    function createCascadeDirectories(string|array $directories, $permission = 0755)
    {
        if (!is_array($directories)) $directories = [$directories];
        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, $permission, true);
            }
        }
    }
}

if (!function_exists('mapColumnType')) {

    /**
     * Map the Doctrine column type to the corresponding Laravel data type.
     *
     * @param string $doctrineType
     * @return string
     */
    function mapColumnType(string $doctrineType): string
    {
        // Add more mappings as needed
        $mappings = [
            'string'    => ['string', 'text', 'varchar', 'char', 'enum', 'set'],
            'integer'   => ['integer', 'bigint', 'smallint'],
            'float'     => ['float', 'double', 'real'],
            'boolean'   => ['boolean', 'bool'],
            'datetime'  => ['date', 'datetime'],
            'timestamp'  => ['timestamp'],
            'json'      => ['jsonb', 'json']
        ];

        foreach ($mappings as $laravelType => $doctrineTypes) {
            if (in_array($doctrineType, $doctrineTypes)) {
                return $laravelType;
            }
        }

        // Default to "string" for unknown types
        return 'string';
    }
}

if (!function_exists('casts')) {

    /**
     * Get the fillable attributes and their cast types.
     *
     * @param array $fillableAttributes
     * @param array  $excludeColumns
     * @return array
     */
    function casts(array $fillableAttributes, string $separator = ':', array $excludeColumns = []): array
    {
        $fillableCasts = [];

        $maxStringLength = max(array_filter(array_map(function ($string) use ($separator, $excludeColumns) {
            if (!in_array($string, $excludeColumns, true))
                return strlen(explode($separator, $string)[0]);
        }, $fillableAttributes)));

        foreach ($fillableAttributes as $attribute) {
            $parts = explode($separator, $attribute, 2);

            $space = '';

            if (count($parts) === 2) {
                [$attributeName, $castType] = $parts;

                if (!in_array($attributeName, $excludeColumns, true)) {

                    for ($i = ($maxStringLength - strlen($attributeName)); $i > 0; --$i) {
                        $space .= ' ';
                    }

                    $value = $castType === 'datetime' ? "$castType:Y-m-d H:i:s" : "$castType";

                    $fillableCasts[] = "'{$attributeName}' {$space} => '{$value}'";
                }
            }
        }

        return $fillableCasts;
    }
}


if (!function_exists('tableSchema')) {
    /**
     * Get the table schema for the given table and connection.
     *
     * @param string $table
     * @param string $connection
     * @param array  $excludeColumns
     * @return array
     */
    function tableSchema(string $table, string $connection, array $excludeColumns = []): array
    {
        $excludeColumns = array_merge($excludeColumns, ['id', 'created_by', 'created_at', 'updated_at']);
        $schema = \Illuminate\Support\Facades\Schema::connection($connection)->getConnection()->getDoctrineSchemaManager();
        $columns = $schema->listTableColumns($table);

        $attributes = [];
        foreach ($columns as $column) {
            // Get the column name and data type
            $columnName = $column->getName();

            if (in_array($columnName, $excludeColumns, true)) {
                // Skip this column if it is in the exclude list
                continue;
            }

            // Get the column name and data type
            $columnType = mapColumnType($column->getType()->getName());
            $attributes[$columnName] = ['type' => $columnType, 'default' => $column->getDefault(), 'nullable' => $column->getNotNull()];
        }

        return $attributes;
    }
}

if (!function_exists('getMaxStringLength')) {
    function getMaxStringLength($array)
    {
        $maxLength = 0;
        $maxString = '';

        foreach ($array as $string) {
            $length = strlen($string);
            if ($length > $maxLength) {
                $maxLength = $length;
                $maxString = $string;
            }
        }

        return $maxString;
    }
}

if (!function_exists('convertToSnakeCase')) {

    /**
     *
     * @param string $string
     * @return string
     */
    function convertToSnakeCase(string $string): string
    {
        $modifiedString = preg_replace('/(?<!^)([A-Z])/', '_$1', $string);
        return strtolower($modifiedString);
    }
}

if(!function_exists('appendCodeToFunction')){
    function appendCodeToFunction($fileContent, $function, $existingContent, $additionalCode) {

        $functionDeclaration = (explode('void', $function)[0]. "void \n\t");


        // Check if the additional code is already present in the existing content
        if (strpos($existingContent, $additionalCode) === false) {
            // Append the new code to the existing content
            $modifiedContent = $existingContent . "\n" . $additionalCode;

            // Replace the existing content in the file
            $fileContent = str_replace($function, $functionDeclaration . "{\n" . $modifiedContent . "\n\n\t}\n", $fileContent);
        }
        
        /* // Use a regular expression to find the function declaration
        $pattern = "/(function\s+" . preg_quote($functionName, '/') . "\s*\([^)]*\))[^{]*{([^}]*)}/s";
        ///$pattern = "/(function\s+" . preg_quote($functionName, '/') . "\s*\([^)]*\))\s*{((?:[^{}]+|(?R))*)}/s";

        if (preg_match($pattern, $fileContent, $matches)) {
            
            $functionDeclaration = $matches[1];
            ///$existingContent = ($matches[2]);

            $functionDeclaration = $functionDeclaration. ": void \n\t";

            // Append the new code to the existing content
            $modifiedContent = $existingContent . "\n" . $additionalCode;

            // Replace the existing content in the file
            $fileContent = str_replace($matches[0], $functionDeclaration . "{" . $modifiedContent . "\n\t}", $fileContent);
        } */
        
        return $fileContent;
    }
}

if(!function_exists('getFunctionContent')){
    /* function getFunctionContent($fileContent, $functionName) {
        // Use a regular expression to find the function declaration
        $pattern = "/(function\s+" . preg_quote($functionName, '/') . "\s*\([^)]*\))[^{]*{([^}]*)}/s";
        if (preg_match($pattern, $fileContent, $matches)) {
            return $matches[2];
        }
        return null; // Function not found
    } */


    function getFunction($class, $functionName) {
        $reflectionClass = new ReflectionClass($class);

        if ($reflectionClass->hasMethod($functionName)) {
            $method = $reflectionClass->getMethod($functionName);
            $startLine = $method->getStartLine();
            $endLine = $method->getEndLine();
            $sourceCode = file($reflectionClass->getFileName());
            ///$content = implode('', array_slice($sourceCode, $startLine - 1, $endLine - $startLine + 1));
            ///$content = implode('', array_slice($sourceCode, $startLine, $endLine - $startLine));
            $content = implode('', array_slice($sourceCode, $startLine - 1, $endLine - $startLine + 1));

            return $content;
        }

        return null;
    }

}



/**
 * Unset all items from an array except for the specified keys.
 *
 * @param array $array The input array.
 * @param array $keys The keys to keep in the array.
 * @return void
 */
function unset_all_except(array &$array, array $keys): void
{

    foreach ($array as $key => $value) {
        if (!in_array($key, $keys)) {
            unset($array[$key]);
        }
    }
}

function getPaginationFormat()
{
    return [
        'current_page',
        'data',
        'first_page_url',
        'from',
        'last_page',
        'last_page_url',
        'links' => [
            [
                'url',
                'label',
                'active',
            ],
            [
                'url',
                'label',
                'active',
            ],
            [
                'url',
                'label',
                'active',
            ],
        ],
        'next_page_url',
        'path',
        'per_page',
        'prev_page_url',
        'to',
        'total'
    ];
}
function getFunctionContentFromFile($filePath, $functionName, $all = false) {
    if (file_exists($filePath)) {
        $sourceCode = file($filePath);
        $functionDeclaration = "function $functionName";

        $functionStartLine = null;
        $functionEndLine = null;

        // Find the start and end lines of the function
        for ($i = 0; $i < count($sourceCode); $i++) {
            if (strpos($sourceCode[$i], $functionDeclaration) !== false) {
                $functionStartLine = $i;
                break;
            }
        }

        if ($functionStartLine !== null) {
            // Find the closing curly bracket of the function
            $bracketCount = 0;
            for ($i = $functionStartLine + 1; $i < count($sourceCode); $i++) {
                
                $line = trim($sourceCode[$i]);

                if (strpos($line, '{') !== false) {
                    $bracketCount++;

                    if ($bracketCount === 1) {
                        $functionStartLine = $i;
                    }
                }  elseif (strpos($line, '}') !== false) {
                    $bracketCount--;
                    if ($bracketCount === 0) {
                        $functionEndLine = $i;
                        break;
                    }
                }
            }

            if ($functionEndLine !== null) {
                // Exclude the function declaration and the closing curly bracket
                ///$content = implode('', array_slice($sourceCode, $functionStartLine - 1, $functionEndLine - $functionStartLine + 2 ));
                $content = implode('', array_slice($sourceCode, $functionStartLine + 1, $functionEndLine - $functionStartLine - 1));
                $functionContent = implode('', array_slice($sourceCode, $functionStartLine - 1, $functionEndLine - $functionStartLine + 2));

                return !$all ? $content : $functionContent;
            }
        }
    }

    return null;
}

if(!function_exists('pascalToSnake')){
    function pascalToSnake($input)
    {
        // Use preg_replace to convert to snake_case
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $input));
    }
}


if(!function_exists('convert_to_snake_case')){
    /**
     *
     * @param string $string
     * @return string
     */
    function convert_to_snake_case(string $string): string {
        $modifiedString = preg_replace('/(?<!^)([A-Z])/', '_$1', $string);
        return strtolower($modifiedString);
    }
}

if(!function_exists('convert_file_path_to_namespace')){
    function convert_file_path_to_namespace($classFilePath)
    {
        $shortPath = short_path($classFilePath);
        
        // Remove '.php' extension
        $withoutExtension = str_replace('.php', '', $shortPath);

        // Replace directory separators with namespace separators
        $withNamespace = str_replace('/', '\\', $withoutExtension);

        // Capitalize the first letter of the resulting string
        $finalNamespace = ucfirst($withNamespace);

        return $finalNamespace;
    }
}