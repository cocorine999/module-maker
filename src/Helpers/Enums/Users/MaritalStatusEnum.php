<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Users;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`MaritalStatusEnum`***
 *
 * This class represents the enumeration of marital statuses in the application.
 * It defines the available marital statuses as constants, including `SINGLE`, `MARRIED`, `DIVORCED` and `WIDOWED`.
 *
 * The default marital status is set to `SINGLE`.
 *
 * @method static array labels()
 *     Get the labels for the marital statuses.
 *     Returns an array with the labels for the marital statuses, where the keys are the marital status constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the marital statuses.
 *     Returns an array with the available marital statuses descriptions.
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Users`***;
 */
enum MaritalStatusEnum: string implements EnumContract
{

    use IsEnum;

    /**
     * Represents the marital status "single".
     *
     * @var string
     */
    case SINGLE             = 'single';

    /**
     * Represents the marital status "married".
     *
     * @var string
     */
    case MARRIED            = 'married';

    /**
     * Represents the marital status "divorced".
     *
     * @var string
     */
    case DIVORCED           = 'divorced';

    /**
     * Represents the marital status "widowed".
     *
     * @var string
     */
    case WIDOWED            = 'widowed';
    
    /**
     * The default marital status value.
     *
     * @return string
     */
    public const DEFAULT    = 'single'; //self::SINGLE;
    
    /**
     * The fallback marital status value.
     *
     * @return string
     */
    public const FALLBACK    = 'single'; //self::SINGLE;

    /**
     * Get the labels for the marital statuses.
     *
     * @return array  The labels for the marital statuses.
     */
    public static function labels(): array
    {
        return [
            self::SINGLE->name   => 'Single',
            self::MARRIED->name  => 'Married',
            self::DIVORCED->name => 'Divorced',
            self::WIDOWED->name  => 'Widowed'
        ];
    }

    /**
     * Get all the marital status enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the marital status enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::SINGLE      => 'Represents the marital status "single".',
            self::MARRIED     => 'Represents the marital status "married".',
            self::DIVORCED    => 'Represents the marital status "divorced".',
            self::WIDOWED     => 'Represents the marital status "widowed".'
        ];
        
    }

    /**
     * Check the marital status to determine the appropriate value for 'Ms./Mrs.'.
     *
     * This method returns the appropriate title based on the `marital status` enum instance.
     * It uses a `match` expression to match the `marital status` enum and return the corresponding title.
     *
     * @return string  The resolved title.
     * @return string  The appropriate value for 'Ms./Mrs.' based on the marital status.
     */
    public function resolveTitle(): string
    {
        return match ($this) {
            self::SINGLE, self::DIVORCED, self::WIDOWED => 'Ms.',
            self::MARRIED                               => 'Mrs.',
            default                                     => 'Ms./Mrs.',
        };
    }
}