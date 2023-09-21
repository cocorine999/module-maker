<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Enums;

use LaravelCoreModule\CoreModuleMaker\Helpers\Enums\Contracts\EnumContract;
use LaravelCoreModule\CoreModuleMaker\Helpers\Mixins\IsEnum;


/**
 * Class ***`TypeAssetManagerEnum`***
 *
 * This class represents the enumeration of asset manager type in the application.
 * It defines the available asset manager type as constants, including `PERSONAL`, `PARTICULIER`, `PROFESSIONAL`, `BROKER`, `REALTOR` and `ENTERPRISE`.
 * 
 * The default lead status is set to `PERSONAL`.
 *
 * @method static array labels()
 *     Get the labels for the asset manager type.
 *     Returns an array with the labels for the asset manager type, where the keys are the asset manager type constants and the values are the corresponding labels.
 *
 * @method static array descriptions()
 *     Get the descriptions for the asset manager type.
 *     Returns an array with the descriptions for the asset manager type, where the keys are the asset manager type constants and the values are the corresponding descriptions.
 *
 * @package ***`\LaravelCoreModule\CoreModuleMaker\Helpers\Enums`***;
 */
enum TypeAssetManagerEnum: string implements EnumContract
{
    use IsEnum;

    /**
     * Represents the personal asset manager type.
     *
     * @var string
     */
    case PERSONAL = 'personal';

    /**
     * Represents the particulier asset manager type.
     *
     * @var string
     */
    case PARTICULIER = 'particulier';

    /**
     * Represents the realtor asset manager type.
     *
     * @var string
     */
    case REALTOR = 'realtor';

    /**
     * Represents the professional asset manager type.
     *
     * @var string
     */
    case PROFESSIONAL = 'professional';

    /**
     * Represents the broker asset manager type.
     *
     * @var string
     */
    case BROKER = 'broker';

    /**
     * The default asset manager type value.
     * 
     * @return string
     */
    public const DEFAULT          = 'personal'; //self::PERSONAL;
    
    /**
     * The fallback asset manager type value.
     * 
     * @return string
     */
    public const FALLBACK         = 'personal'; //self::PERSONAL;

    /**
     * Get the labels for the asset managers type.
     *
     * @return array The labels for the asset managers type.
     */
    public static function labels(): array
    {
        return [
            self::PERSONAL->name     => 'Personal',
            self::PARTICULIER->name  => 'Particulier',
            self::REALTOR->name      => 'Realtor',
            self::PROFESSIONAL->name => 'Professional',
            self::BROKER->name       => 'Broker'
        ];
    }

    /**
     * Get all the asset managers type enum descriptions as an array.
     *
     * @return array An array containing all the descriptions for the enum values.
     */
    public static function descriptions(): array
    {
        return [
            self::PERSONAL     => 'Represents the personal asset manager type.',
            self::PARTICULIER  => 'Represents the particular asset manager type.',
            self::REALTOR      => 'Represents the realtor asset manager type.',
            self::PROFESSIONAL => 'Represents the professional asset manager type.',
            self::BROKER       => 'Represents the broker asset manager type.'
        ];
        
    }
}