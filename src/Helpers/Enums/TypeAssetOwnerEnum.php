<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`TypeAssetOwnerEnum`***
 *
 * This class represents the enumeration of account types in the application.
 * It defines the available account types as constants, including `FULL_ACTIVE`, PARTIEL_ACTIVE and `PASSIVE`.
 * 
 * The default lead status is set to `FULL_ACTIVE`.
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
enum TypeAssetOwnerEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the active asset owner type.
     *
     * @var string
     */
    case FULL_ACTIVE = 'active';

    /**
     * Represents the partial active asset owner type.
     *
     * @var string
     */
    case PARTIEL_ACTIVE = 'partial-active';

    /**
     * Represents the passive asset owner type.
     *
     * @var string
     */
    case PASSIVE = 'passive';

    /**
     * The default asset owner type value.
     * 
     * @return string
     */
    public const DEFAULT          = 'active'; //self::FULL_ACTIVE;
    
    /**
     * The fallback asset owner type value.
     * 
     * @return string
     */
    public const FALLBACK         = 'active'; //self::FULL_ACTIVE;

    /**
     * Get the labels for the asset owners type.
     *
     * @return array The labels for the asset owners type.
     */
    public static function labels(): array
    {
        return [
            self::FULL_ACTIVE    => 'Full active',
            self::PARTIEL_ACTIVE => 'Partial active',
            self::PASSIVE       => 'Passive'
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
            self::FULL_ACTIVE    => 'Represents the full active asset owner type.',
            self::PARTIEL_ACTIVE => 'Represents the partial active asset owner type.',
            self::PASSIVE       => 'Represents the passive asset owner type.'
        ];
        
    }
}