<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`TypeOfStreetEnum`***
 *
 * This class represents the enumeration of account types in the application.
 * It defines the available account types as constants, including `STREET`, AVENUE and `BOULEVARD`.
 * 
 * The default lead status is set to `STREET`.
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
enum TypeOfStreetEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the street asset owner type.
     *
     * @var string
     */
    case STREET = 'street';

    /**
     * Represents the avenue street type.
     *
     * @var string
     */
    case AVENUE = 'avenue';

    /**
     * Represents the boulevard street type.
     *
     * @var string
     */
    case BOULEVARD = 'boulevard';

    /**
     * Represents the road street type.
     *
     * @var string
     */
    case ROAD = 'road';

    /**
     * Represents the lane street type.
     *
     * @var string
     */
    case LANE = 'lane';

    /**
     * Represents the drive street type.
     *
     * @var string
     */
    case DRIVE = 'drive';

    /**
     * Represents the court street type.
     *
     * @var string
     */
    case COURT = 'court';

    /**
     * Represents the place street type.
     *
     * @var string
     */
    case PLACE = 'place';

    /**
     * Represents the terrace street type.
     *
     * @var string
     */
    case TERRACE = 'terrace';

    /**
     * Represents the way street type.
     *
     * @var string
     */
    case WAY = 'way';

    /**
     * The default street type value.
     * 
     * @return string
     */
    public const DEFAULT          = 'active'; //self::STREET;
    
    /**
     * The fallback asset owner type value.
     * 
     * @return string
     */
    public const FALLBACK         = 'active'; //self::STREET;

    /**
     * Get the labels for the asset owners type.
     *
     * @return array The labels for the asset owners type.
     */
    public static function labels(): array
    {
        return [
            self::STREET       => 'Street',
            self::AVENUE       => 'Avenue',
            self::BOULEVARD    => 'Boulevard'
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
            self::STREET    => 'Represents the full active asset owner type.',
            self::AVENUE => 'Represents the avenue asset owner type.',
            self::BOULEVARD       => 'Represents the boulevard asset owner type.'
        ];
        
    }
}