<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`StateOfLandlord`***
 *
 * This class represents the enumeration of account types in the application.
 * It defines the available account types as constants, including `ACTIVE`, PARTIALLY_ACTIVE and `PASSIVE`.
 * 
 * The default lead status is set to `ACTIVE`.
 *
 * @method static array labels()
 *     Get the labels for the account types.
 *     Returns an array with the labels for the account types, where the keys are the account type constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the account types.
 *     Returns an array with the descriptions for the account types, where the keys are the account type constants and the values are the corresponding descriptions.
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Helpers\Enums`***;
 */
enum StateOfLandlord: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the active asset owner type.
     *
     * @var string
     */
    case ACTIVE             = 'active';

    /**
     * Represents the partially active asset owner type.
     *
     * @var string
     */
    case PARTIALLY_ACTIVE          = 'partially-active';

    /**
     * Represents the passive asset owner type.
     *
     * @var string
     */
    case PASSIVE                  = 'passive';

    /**
     * The default asset owner type value.
     * 
     * @return string
     */
    public const DEFAULT          = 'partially-active'; //self::ACTIVE;
    
    /**
     * The fallback asset owner type value.
     * 
     * @return string
     */
    public const FALLBACK         = 'partially-active'; //self::ACTIVE;

    /**
     * Get the labels for the asset owners type.
     *
     * @return array The labels for the asset owners type.
     */
    public static function labels(): array
    {
        return [
            self::ACTIVE            => 'Active Engagement',
            self::PARTIALLY_ACTIVE  => 'Intermittent active',
            self::PASSIVE           => 'No Engagement'
        ];
    }

    /**
     * Get all the asset owners type enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::ACTIVE    => 'Active Engagement: These landlords are actively involved in managing their properties and regularly engage with the platform.',
            self::PARTIALLY_ACTIVE => 'Intermittent Engagement: These landlords may not be as active as the "Active" category but still maintain some level of involvement.',
            self::PASSIVE        => 'Limited or No Engagement: These landlords have minimal or no engagement with the platform.'
        ];
        
    }
}