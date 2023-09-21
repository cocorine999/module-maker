<?php

declare(strict_types=1);

/**
 *
 * @param string $string
 * @return string
 */
function convertToSnakeCase(string $string): string {
    $modifiedString = preg_replace('/(?<!^)([A-Z])/', '_$1', $string);
    return strtolower($modifiedString);
}
