<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`AccessLevelEnum`***
 * 
 * This class represents the enumeration of access levels in the application.
 * It defines the available access levels as constants, including `READ_ONLY`, `READ_WRITE`, and `FULL_ACCESS`.
 * 
 * The default access level is set to `FULL_ACCESS`.
 *
 * @method static array labels()
 *     Get the labels for the access levels.
 *     Returns an array with the labels for the access levels, where the keys are the access level constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the access levels.
 *     Returns an array with the descriptions for the access levels, where the keys are the access level constants and the values are the corresponding descriptions.
 *
 * @package ***`\App\Helpers\Enums`***;
 */
enum AccessLevelEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents a read-only access level.
     *
     * @var string
     */
    case READ_ONLY = 'read_only';

    /**
     * Represents a read-write access level.
     *
     * @var string
     */
    case READ_WRITE = 'read_write';

    /**
     * Represents full access level.
     *
     * @var string
     */
    case FULL_ACCESS = 'full_access';

    /**
     * Represents a custom priority.
     *
     * @var string
     */
    case CUSTOM = 'custom';

    /**
     * The default access level.
     * 
     * @return string
     */
    public const DEFAULT          = 'read_write'; //self::READ_WRITE;
    
    /**
     * The fallback access level.
     * 
     * @return string
     */
    public const FALLBACK         = 'read_write'; //self::READ_WRITE;

    /**
     * Get the labels for the access levels.
     *
     * @return array The labels for the access levels.
     */
    public static function labels(): array
    {
        return [
            self::READ_ONLY   => 'Read-Only',
            self::READ_WRITE  => 'Read/Write',
            self::FULL_ACCESS => 'Full Access',
            self::CUSTOM      => 'Custom',
        ];
    }

    /**
     * Get descriptions for the access levels.
     *
     * @return array An array containing descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::READ_ONLY   => 'Allows read-only access to the resource.',
            self::READ_WRITE  => 'Allows read and write access to the resource.',
            self::FULL_ACCESS => 'Grants full access to the resource.',
            self::CUSTOM      => 'Grants custom access to the resource.',
        ];
    }
}