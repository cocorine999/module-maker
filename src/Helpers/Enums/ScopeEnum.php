<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`ScopeEnum`***
 * 
 * This class represents the enumeration of scopes in the application.
 * It defines the available scopes as constants, including `GLOBAL`, `ORGANIZATION_SPECIFIC`, `RESOURCE_SPECIFIC`, and `DEPARTMENT_SPECIFIC`.
 * 
 * The default scope is set to `GLOBAL`.
 *
 * @method static array labels()
 *     Get the labels for the visibility options.
 *     Returns an array with the labels for the visibility options, where the keys are the visibility option constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the visibility options.
 *     Returns an array with the descriptions for the visibility options, where the keys are the visibility option constants and the values are the corresponding descriptions.
 *
 * @package ***`\App\Helpers\Enums`***;
 */
enum ScopeEnum: string implements EnumContract
{
    use IsEnum;


    /**
     * Represents a global scope.
     *
     * @var string
     */
    case GLOBAL = 'global';

    /**
     * Represents an organization-specific scope.
     *
     * @var string
     */
    case ORGANIZATION_SPECIFIC = 'organization_specific';

    /**
     * Represents a resource-specific scope.
     *
     * @var string
     */
    case RESOURCE_SPECIFIC = 'resource_specific';

    /**
     * Represents a department-specific scope.
     *
     * @var string
     */
    case DEPARTMENT_SPECIFIC = 'department_specific';

    /**
     * The default scope.
     * 
     * @return string
     */
    public const DEFAULT          = 'global'; //self::SHARED;
    
    /**
     * The fallback scope.
     * 
     * @return string
     */
    public const FALLBACK         = 'global'; //self::SHARED;

    /**
     * Get the labels for the scopes.
     *
     * @return array The labels for the scopes.
     */
    public static function labels(): array
    {
        return [
            self::GLOBAL => 'Global',
            self::ORGANIZATION_SPECIFIC => 'Organization Specific',
            self::RESOURCE_SPECIFIC => 'Resource Specific',
            self::DEPARTMENT_SPECIFIC => 'Department Specific'
        ];
    }

    /**
     * Get descriptions for the scopes.
     *
     * @return array An array containing descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::GLOBAL => 'Applies globally to all users.',
            self::ORGANIZATION_SPECIFIC => 'Applies within an organization or tenant.',
            self::RESOURCE_SPECIFIC => 'Applies to a specific resource or module.',
            self::DEPARTMENT_SPECIFIC => 'Applies to a specific department within an organization.',
        ];
    }
}