<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Users;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`SexEnum`***
 *
 * This class represents the enumeration of marital statuses in the application.
 * It defines the available marital statuses as constants, including `MALE` and `FEMALE`.
 *
 * The default sexes/genders is set to `MALE`.
 *
 * @method static array labels()
 *     Get the labels for the marital statuses.
 *     Returns an array with the labels for the marital statuses, where the keys are the sexes/genders constants and the values are the corresponding labels.
 * 
 * @method static array descriptions()
 *     Get the descriptions for the sexes/genders.
 *     Returns an array with the available sexes/genders descriptions.
 * 
 * @method string resolveGender()
 *     Returns the appropriate title based on the `sexes/genders` enum instance.
 * 
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Users`***;
 */
enum SexEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the sex/gender "male".
     *
     * @var string
     */
    case MALE = 'male';

    /**
     * Represents the sex/gender "female".
     *
     * @var string
     */
    case FEMALE = 'female';

    /**
     * Represents the sex/gender "unknown".
     *
     * @var string
     */
    case UNKNOWN = 'unknown';

    /**
     * The default sex/gender value.
     * 
     * @return string
     */
    public const DEFAULT          = 'unknown'; //self::UNKNOWN;
    
    /**
     * The fallback sex/gender value.
     * 
     * @return string
     */
    public const FALLBACK         = 'unknown'; //self::UNKNOWN;

    /**
     * Get the labels for the sexes/genders.
     *
     * @return array The labels for the sexes/genders.
     */
    public static function labels(): array
    {
        return [
            self::MALE->value     => 'Male',
            self::FEMALE->value   => 'Female',
            self::UNKNOWN->value  => 'Unknown'
        ];
    }

    /**
     * Get all the sexes/genders enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::MALE->value     => 'Represents the sex/gender "male".',
            self::FEMALE->value   => 'Represents the sex/gender "female".',
            self::UNKNOWN->value  => 'Represents the sex/gender "unknown".'
        ];
        
    }

    /**
     * Get the gender abbreviation for the sex/gender constant.
     *
     * This method returns the gender abbreviation ('M' for male, 'F' for female) for the current sex/gender constant instance.
     * It uses a `match` expression to match the `sex/gender` enum and return the corresponding gender abbreviation.
     *
     * @return string The gender abbreviation ('M' for male, 'F' for female).
     */
    public function resolveGender(): string
    {
        return match ($this) {
            self::MALE     => 'M',
            self::FEMALE   => 'F',
            self::UNKNOWN  => 'unknown',
            default        => 'unknown',
        };
    }
}