<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;


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

        dd($folderName);
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
        return preg_replace('/[^a-z0-9\-]/', '', $string); // Remove non-alphanumeric characters
    
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
        $excludeColumns = array_merge($excludeColumns, ['id', 'slug', 'created_by', 'created_at', 'updated_at']);
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
