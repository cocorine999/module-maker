<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`TypeOfLandlordEnum`***
 *
 * This class represents the enumeration of account types in the application.
 * It defines the available account types as constants, including `PROFESSIONAL`, CASUAL and `INVESTOR`.
 * 
 * The default lead status is set to `PROFESSIONAL`.
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
enum TypeOfLandlordEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the professional asset owner type.
     *
     * @var string
     */
    case PROFESSIONAL              = 'professional';

    /**
     * Represents the casual asset owner type.
     *
     * @var string
     */
    case CASUAL                    = 'casual';

    /**
     * Represents the investor asset owner type.
     *
     * @var string
     */
    case INVESTOR                  = 'investor';

    /**
     * The default asset owner type value.
     * 
     * @return string
     */
    public const DEFAULT          = 'active'; //self::PROFESSIONAL;
    
    /**
     * The fallback asset owner type value.
     * 
     * @return string
     */
    public const FALLBACK         = 'active'; //self::PROFESSIONAL;

    /**
     * Get the labels for the asset owners type.
     *
     * @return array The labels for the asset owners type.
     */
    public static function labels(): array
    {
        return [
            self::PROFESSIONAL    => 'Full active',
            self::CASUAL => 'Partial active',
            self::INVESTOR        => 'Passive'
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
            self::PROFESSIONAL    => 'Represents the full active asset owner type.',
            self::CASUAL => 'Represents the partial active asset owner type.',
            self::INVESTOR        => 'Represents the passive asset owner type.'
        ];
        
    }
}